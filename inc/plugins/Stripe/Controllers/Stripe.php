<?php
namespace Plugins\Stripe\Controllers;

class Stripe extends \CodeIgniter\Controller
{
    public function __construct(){
        $reflect = new \ReflectionClass(get_called_class());
        $this->module = strtolower( $reflect->getShortName() );
        $this->config = include realpath( __DIR__."/../Config.php" );
        include get_module_dir( __DIR__ , 'Libraries/vendor/autoload.php');

        $this->publishable_key = get_option("stripe_publishable_key", "");
        $this->secret_key = get_option("stripe_secret_key", "");
        $this->plan = get_payment_plan( uri("segment", 3), uri("segment", 4) );

        if( !get_option("stripe_one_time_status", 0) || empty($this->plan) || $this->publishable_key == "" || $this->secret_key == "" ){
            redirect_to( base_url() );
        }
    }

    public function index($ids = "")
    {
        try {
            if(!get_user("id")){
                redirect_to( base_url("login"), true);
            }

            if(get_user_data("is_subscription", 0)){
                $error = __("You are using the monthly payment plan. Cancel it if you want to change the package or change your payment method.");
                redirect_to( base_url( "profile/index/plan?error=".urlencode($error) ) );
            }

            $iszdc = isZeroDecimalCurrency( get_option('payment_currency','USD') );
            
            \Stripe\Stripe::setApiKey( get_option("stripe_secret_key", "") );

            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => strtolower( get_option('payment_currency', 'USD') ),
                            'unit_amount' => round( !$iszdc ? $this->plan->amount : ($this->plan->amount / 100), 2)*100,
                            'product_data' => [
                                'name' =>  $this->plan->name,
                                'description' => $this->plan->desc
                            ]
                        ],
                        'quantity' => 1,
                    ]
                ],
                'mode' => 'payment',
                'success_url' => base_url("stripe/complete/".$ids."/".$this->plan->by),
                'cancel_url' =>  base_url("payment/failed"),
            ]);

            set_session(["stripe_check" => $session->id]);

            return view("Plugins\Stripe\Views\payment", [ "checkout_session_id" => $session->id ]);

        }catch (\Stripe\Exception\StripeConnectionException $e) {
            $error = [
                "status" => "error",
                "message" => $e->getMessage()
            ];

            redirect_to( base_url("payment/failed?".http_build_query($error) ) );
        }
    }

    public function complete($ids = ""){
        try {

            if(!get_session("stripe_check")) redirect_to( get_module_url("index/".$ids."/".$this->plan->by) );

            \Stripe\Stripe::setApiKey( get_option("stripe_secret_key", "") );
            $payment = \Stripe\Checkout\Session::retrieve( get_session("stripe_check") );

            remove_session(["stripe_check"]);

            $intent = \Stripe\PaymentIntent::retrieve( $payment->payment_intent );

            if( $intent->status == "succeeded" ){
                $data = [
                    'type' => 'stripe',
                    'plan' => $this->plan->id,
                    'by' => $this->plan->by,
                    'transaction_id' => $payment->payment_intent,
                    'amount' => $payment->amount_total/100,
                ];
 
                payment_save($data);
            }else{
                redirect_to( base_url("payment/failed") );
            }

        } catch (Exception $e) {
            echo $e->getMessage();
            exit(0);
        }

    }
}
