<?php
namespace Plugins\Stripe_recurring\Controllers;

class Stripe_recurring extends \CodeIgniter\Controller
{
    public function __construct(){
        $reflect = new \ReflectionClass(get_called_class());
        $this->module = strtolower( $reflect->getShortName() );
        $this->config = include realpath( __DIR__."/../Config.php" );
        include get_module_dir( __DIR__ , 'Libraries/vendor/autoload.php');

        $this->publishable_key = get_option("stripe_publishable_key", "");
        $this->secret_key = get_option("stripe_secret_key", "");
        if ( uri("segment", 2) != "webhook" ) {
            $this->plan = get_payment_plan( uri("segment", 3), uri("segment", 4) );
            if( !get_option("stripe_recurring_status", 0) || empty($this->plan) || $this->publishable_key == "" || $this->secret_key == "" ){
                redirect_to( base_url() );
            }
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

            $user_id = get_user("id");
            $email = get_user("email");
            $customer_id = get_user_data("stripe_customer_id", "");
            $plan_result = false;

            if (!$customer_id) {
                $customer = \Stripe\Customer::create([
                    "email" => $email,
                    "metadata" => [
                        "user_id" => $user_id
                    ]
                ]);
                
                if (empty($customer->id)) {
                    throw new ErrorException("Couldn't create the new customer");
                } 

                $customer_id = $customer->id;
                update_user_data("stripe_customer_id", $customer_id);
            }

            if ($customer_id) {
                try {
                    $customer = \Stripe\Customer::retrieve($customer_id);
                } catch (\Exception $e) {
                    $customer_id = null;
                }

                if (!empty($customer->id)) {
                    $update = false;
                    if ($customer->email != $email) {
                        $customer->email = $email;
                        $update = true;
                    }

                    if (isset($customer->metadata->user_id) && $customer->metadata->user_id != $user_id) {
                        $customer->metadata->user_id = $user_id;
                        $update = true;
                    }

                    if ($update) {
                        $customer->save();
                    }
                } 
            }

            $plan_id = "plan"
                     . "-" . $this->plan->id
                     . "-" . uniqid()
                     . "-" . ($this->plan->by == 2 ? "annualy" : "monthly")
                     . "-" . ( $iszdc? round($this->plan->amount): $this->plan->amount*100 )
                     . "-" . strtolower( get_option("payment_currency", "USD") );

            try {
                $plan_result = \Stripe\Plan::retrieve($plan_id);
            } catch (\Exception $e) {}

            if (empty($plan_result)) {
                $plan_result = \Stripe\Plan::create([
                    "id" => $plan_id,
                    "amount" => $iszdc? round($this->plan->amount): $this->plan->amount*100,
                    "interval" => $this->plan->by == 2 ? "year" : "month",
                    "product" => [
                        "name" => $this->plan->name
                                . " - " 
                                . ($this->plan->by == 2 ? "Annualy" : "Monthly")
                    ],
                    "currency" => get_option("payment_currency", "USD")
                ]);
            }
            
            $session = \Stripe\Checkout\Session::create([
                'customer' => $customer_id,
                'payment_method_types' => ['card'],
                'subscription_data' => [
                    'items' => [
                        ['plan' => $plan_id]
                    ],
                ],
                "metadata" => [
                    "order_id" => $this->plan->id,
                    "user_id" => $user_id
                ],
                'success_url' => base_url("stripe_recurring/complete/".$ids."/".$this->plan->by),
                'cancel_url' =>  base_url("payment/failed"),
            ]);

            set_session(["stripe_recurring_check" => $session->id]);

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
            if(!get_session("stripe_recurring_check")) redirect_to( get_module_url("index/".$ids."/".$this->plan->by) );
            
            \Stripe\Stripe::setApiKey( get_option("stripe_secret_key", "") );
            $payment = \Stripe\Checkout\Session::retrieve( get_session("stripe_recurring_check") );

            remove_session(["stripe_recurring_check"]);

            if($payment->customer){
                $subscription = [
                    "type" => "stripe_recurring",
                    "plan" => $this->plan->id,
                    "by" => $this->plan->by,
                    "subscription_id" => $payment->subscription,
                    "customer_id" => $payment->customer,
                ];

                payment_save_subscription($subscription);
            }else{
                redirect_to( get_url("payment/failed") );
            }

        } catch (\Exception $e) {
            $error = [
                "status" => "error",
                "message" => $e->getMessage()
            ];

            redirect_to( base_url("payment/failed?".http_build_query($error) ) );
        }
    }

    public function webhook(){
        try {
            sleep(3);
            
            \Stripe\Stripe::setApiKey( $this->secret_key );

            $webhook_id = get_option('stripe_webhook_id', '');

            $payload = @file_get_contents('php://input');
            $sig_header = @$_SERVER['HTTP_STRIPE_SIGNATURE'];
            $event = null;

            try {
                $event = \Stripe\Webhook::constructEvent(
                    $payload, $sig_header, $webhook_id
                );
            } catch(\UnexpectedValueException $e) {
                // Invalid payload
                http_response_code(400);
                exit();
            } catch(\Stripe\Exception\SignatureVerificationException $e) {
                // Invalid signature
                http_response_code(400);
                exit();
            }

            switch ($event->type) {
                case "invoice.payment_succeeded":
                    $paymentIntent = $event->data->object; 
                    
                    if (empty($paymentIntent->charge)) {
                        http_response_code(400);
                        exit;
                    }

                    if (empty($paymentIntent->subscription)) {
                        http_response_code(400);
                        exit;
                    }

                    $iszdc = isZeroDecimalCurrency( get_option('payment_currency','USD') );

                    payment_update_subscription([
                        "subscription_id" => $paymentIntent->subscription,
                        'transaction_id' => $paymentIntent->charge,
                        'amount' => $iszdc ? $paymentIntent->amount_paid : ($paymentIntent->amount_paid / 100)
                    ]);

                    break;

                case "customer.subscription.deleted":
                    $paymentMethod = $event->data->object;
                    payment_delete_supscription($paymentMethod->id);
                    break;
                
                default:
                    break;
            }

            http_response_code(200);
        } catch (\Exception $e) {
            pr($e,1);
        }
    }
}
