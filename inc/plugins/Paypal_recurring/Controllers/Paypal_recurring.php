<?php
namespace Plugins\Paypal_recurring\Controllers;

class Paypal_recurring extends \CodeIgniter\Controller
{
    public function __construct(){

        $reflect = new \ReflectionClass(get_called_class());
        $this->module = strtolower( $reflect->getShortName() );
        $this->config = include realpath( __DIR__."/../Config.php" );
        include get_module_dir( __DIR__ , 'Libraries/vendor/autoload.php');

        $this->client_id = get_option("paypal_client_id");
        $this->client_secret = get_option("paypal_client_secret_key");

        if ( uri("segment", 2) != "webhook" ) {
            $this->plan = get_payment_plan( uri("segment", 3), uri("segment", 4) );
            if( !get_option("paypal_recurring_status") || empty($this->plan) || $this->client_id == "" || $this->client_secret == "" ){
                redirect_to( base_url() );
            }
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

            $this->plan->amount = round($this->plan->amount, 2);

            $cycles = '12';
            $frequency = 'MONTH';
            if($this->plan->by == 2){
                $cycles = '2';
                $frequency = 'YEAR';
            }

            $create_plan = new \PayPal\Api\Plan();
            $create_plan->setName( "Package: ".$this->plan->name. " - " . ($this->plan->by == 2?"Anually":"Monthly") )
                ->setDescription($this->plan->desc)
                ->setType('FIXED');

            // Set billing plan definitions
            $paymentDefinition = new \PayPal\Api\PaymentDefinition();
            $paymentDefinition->setName('Regular Payments')
                ->setType('REGULAR')
                ->setFrequency($frequency)
                ->setFrequencyInterval('1')
                ->setCycles($cycles)
                ->setAmount(new \PayPal\Api\Currency(array(
                    'value' => $this->plan->amount,
                    'currency' => get_option("payment_currency", "USD")
                )
            ));

            // Set merchant preferences
            $merchantPreferences = new \PayPal\Api\MerchantPreferences();
            $merchantPreferences
                ->setReturnUrl( base_url("paypal_recurring/complete/".$ids."/".$this->plan->by) )
                ->setCancelUrl( base_url("payment/failed") )
                ->setAutoBillAmount('yes')
                ->setInitialFailAmountAction('CONTINUE')
                ->setMaxFailAttempts('0')
                ->setSetupFee(new \PayPal\Api\Currency( ['value' => $this->plan->amount, 'currency' => "USD" ]));

            $create_plan->setPaymentDefinitions([$paymentDefinition]);
            $create_plan->setMerchantPreferences($merchantPreferences);

            $createdPlan = $create_plan->create($this->paypal);

            $patch = new \PayPal\Api\Patch();
            $patch->setOp('replace')
                ->setPath('/')
                ->setValue( json_decode('{"state":"ACTIVE"}') );

            $patchRequest = new \PayPal\Api\PatchRequest();
            $patchRequest->addPatch($patch);
            $createdPlan->update($patchRequest, $this->paypal);
            $patchedPlan = \PayPal\Api\Plan::get($createdPlan->getId(), $this->paypal);
            
            
            // Create new agreement
            $startDate = date('c', time() + 30);
            $agreement = new \PayPal\Api\Agreement();
            $agreement->setName( "Plans: ".$this->plan->name. " - " . ($this->plan->by == 2?"Anually":"Monthly") )
                ->setDescription( "Plans: ".$this->plan->name. " - " . ($this->plan->by == 2?"Anually":"Monthly") )
                ->setStartDate($startDate);

            // Set plan id
            $paypal_plan = new \PayPal\Api\Plan();
            $paypal_plan->setId($patchedPlan->getId());
            $agreement->setPlan($paypal_plan);

            // Add payer type
            $payer = new \PayPal\Api\Payer();
            $payer->setPaymentMethod('paypal');
            $agreement->setPayer($payer);

            $agreement = $agreement->create($this->paypal);
            $approvalUrl = $agreement->getApprovalLink();
            
            redirect_to($approvalUrl);

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
            $agreement = new \PayPal\Api\Agreement();

            //Execute agreement
            $payment = $agreement->execute( post("token"), $this->paypal);

            /*REMOVE OLD SUPSCRIBTION*/
            $this->cancel_subscription();

            $subscription = [
                "type" => "paypal_recurring",
                "plan" => $this->plan->id,
                "by" => $this->plan->by,
                "subscription_id" => $payment->getId(),
                "customer_id" => $payment->getPayer()->getPayerInfo()->getPayerId(),
            ];

            payment_save_subscription($subscription);

        } catch (Exception $e) {
            $error = [
                "status" => "error",
                "message" => $e->getMessage()
            ];

            redirect_to( base_url("payment/failed?".http_build_query($error) ) );
        }

    }

    public function cancel_subscription(){
        $user_id = get_user("id");
        $subscription = db_get("*", TB_PAYMENT_SUBSCRIPTIONS, ["type" => "paypal_recurring", "uid" => $user_id]);

        if($subscription){
            $agreement = new \PayPal\Api\Agreement();
            $agreement->setId($subscription->subscription_id);
            $agreementStateDescriptor = new \PayPal\Api\AgreementStateDescriptor();
            $agreementStateDescriptor->setNote("Cancel the agreement");

            try {
                $agreement->cancel($agreementStateDescriptor, $this->paypal);
                $cancelAgreementDetails = \PayPal\Api\Agreement::get($agreement->getId(), $this->paypal); 
                payment_delete_supscription($subscription->subscription_id);
                return true;               
            } catch (Exception $e) {
                return false;
            }
        }
    }

    public function webhook(){
        $requestBody = file_get_contents('php://input');
        $headers = getallheaders();
        $headers = array_change_key_case($headers, CASE_UPPER);

        if(isset($headers['PAYPAL-AUTH-ALGO'])){
            $signatureVerification = new \PayPal\Api\VerifyWebhookSignature();
            $signatureVerification->setAuthAlgo($headers['PAYPAL-AUTH-ALGO']);
            $signatureVerification->setTransmissionId($headers['PAYPAL-TRANSMISSION-ID']);
            $signatureVerification->setCertUrl($headers['PAYPAL-CERT-URL']);
            $signatureVerification->setWebhookId( get_option('paypal_webhook_id', '') );
            $signatureVerification->setTransmissionSig($headers['PAYPAL-TRANSMISSION-SIG']);
            $signatureVerification->setTransmissionTime($headers['PAYPAL-TRANSMISSION-TIME']);

            $signatureVerification->setRequestBody($requestBody);
            $request = clone $signatureVerification;
            $request = json_decode($request);

            try {
                $output = $signatureVerification->post($this->paypal);
                if($output->verification_status == "SUCCESS"){
                    $request = $request->webhook_event;

                    switch ($request->event_type) {
                        case 'PAYMENT.SALE.COMPLETED':
                            if (isset($request->resource)) {
                                payment_update_subscription([
                                    "subscription_id" => $request->resource->billing_agreement_id,
                                    'transaction_id' => $request->resource->id,
                                    'amount' => $request->resource->amount->total
                                ]);
                            }
                            break;

                        case 'BILLING.SUBSCRIPTION.CANCELLED':
                            if (isset($request->resource)) {
                                payment_cancel_subscription($request->resource->id);
                            }
                            break;

                        default:
                            break;
                    }
                }
            } catch (\Exception $e) {
                file_put_contents(FCPATH."test.txt", $e);
            }
        }
    }
}