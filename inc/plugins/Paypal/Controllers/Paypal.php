<?php
namespace Plugins\Paypal\Controllers;

class Paypal extends \CodeIgniter\Controller
{
    public function __construct(){
        $reflect = new \ReflectionClass(get_called_class());
        $this->module = strtolower( $reflect->getShortName() );
        $this->config = include realpath( __DIR__."/../Config.php" );
        include get_module_dir( __DIR__ , 'Libraries/vendor/autoload.php');

        $this->client_id = get_option("paypal_client_id");
        $this->client_secret = get_option("paypal_client_secret_key");
        $this->plan = get_payment_plan( uri("segment", 3), uri("segment", 4) );

        if( !get_option("paypal_one_time_status", 0) || empty($this->plan) || $this->client_id == "" || $this->client_secret == "" ){
            redirect_to( base_url() );
        }

        $this->paypal = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential($this->client_id, $this->client_secret)
        );

        if(get_option("payment_environment", 0)){
            $this->paypal->setConfig(
                array(
                    'mode' => 'live',
                )
            );
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

            $payer = new \PayPal\Api\Payer();
            $payer->setPaymentMethod('paypal');

            $items[0] = new \PayPal\Api\Item();
            $items[0]->setName( $this->plan->name." - ".($this->plan->by==2?__("Annually"):__("Monthly")) )
            ->setCurrency( get_option("payment_currency", "USD") )
            ->setQuantity(1)
            ->setSku($this->plan->id)
            ->setPrice( $this->plan->amount );

            $itemList = new \PayPal\Api\ItemList();
            $itemList->setItems($items);

            $amount = new \PayPal\Api\Amount();
            $amount->setTotal( $this->plan->amount );
            $amount->setTotal( $this->plan->amount );
            $amount->setCurrency( get_option("payment_currency", "USD") );

            $transaction = new \PayPal\Api\Transaction();
            $transaction->setAmount($amount);
            $transaction->setItemList($itemList);
            
            $redirectUrls = new \PayPal\Api\RedirectUrls();
            $redirectUrls->setReturnUrl( base_url("paypal/complete/".$ids."/".$this->plan->by) )
                ->setCancelUrl( base_url("payment/failed") );
            $payment = new \PayPal\Api\Payment();
            $payment->setIntent('sale')
                ->setPayer($payer)
                ->setTransactions(array($transaction))
                ->setRedirectUrls($redirectUrls);

                set_session(["paypal_check" => true]);
                $payment->create($this->paypal);
                redirect_to($payment->getApprovalLink());

        }catch (\PayPal\Exception\PayPalConnectionException $e) {
            $error = [
                "status" => "error",
                "message" => $e->getMessage()
            ];

            redirect_to( base_url("payment/failed?".http_build_query($error) ) );
        }
    }

    public function complete($ids = "", $plan = ""){

        try {
            if(!get_session("paypal_check")) redirect_to( get_module_url("index/".$ids."/".$plan) );

            $payment = \PayPal\Api\Payment::get( post("paymentId") , $this->paypal);
            $execution = new \PayPal\Api\PaymentExecution();
            $execution->setPayerId( post("PayerID") );

            $payment = $payment->execute($execution, $this->paypal);

            remove_session(["paypal_check"]);

            if($payment->getState() == "approved"){
                $data = [
                    'type' => 'paypal',
                    'plan' => $this->plan->id,
                    'transaction_id' => $payment->getTransactions()[0]->getRelatedResources()[0]->getSale()->getId(),
                    'amount' => $payment->getTransactions()[0]->getAmount()->getTotal(),
                    'by' =>$this->plan->by,
                ];

                payment_save($data); 
            }else{
                redirect_to( base_url("payment/unsuccess") );
            }

        } catch (Exception $e) {
            echo $e->getMessage();
            exit(0);
        }

    }
}