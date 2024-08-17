<?php
namespace Plugins\Paypal_recurring\Models;
use CodeIgniter\Model;

class Paypal_recurringModel extends Model
{
	public function __construct(){
        $this->config = parse_config( include realpath( __DIR__."/../Config.php" ) );
        include get_module_dir( __DIR__ , 'Libraries/vendor/autoload.php');
    }

    public function payment_button(){
        $data = [
            "title" => __("Paypal"),
            "desc" => __("Recurring payment"),
            "logo" => get_module_path(__DIR__, "Assets/img/logo.png"),
            "url" => base_url( $this->config['id']. "/index/" . uri("segment", 3) )
        ];

        return [
            'position' => 9999,
            'html' => view( 'Plugins\Paypal_recurring\Views\button', $data )
        ];
    }

    public function cancel_subscription(){
        $subscription_id = get_user_data("subscription_id", "");
        $client_id = get_option("paypal_client_id");
        $client_secret = get_option("paypal_client_secret_key");
        $webhook_id = get_option("paypal_webhook_id");

        if( get_option("paypal_recurring_status") && $client_id && $client_secret && $webhook_id && $subscription_id){

            $this->apiContext = new \PayPal\Rest\ApiContext(
                new \PayPal\Auth\OAuthTokenCredential($client_id, $client_secret)
            );

            if(get_option("payment_environment", 0)){
                $this->apiContext->setConfig(
                    array(
                        'mode' => 'live',
                    )
                );
            }
            
            $agreement = new \PayPal\Api\Agreement();
            $agreement->setId($subscription_id);
            $agreementStateDescriptor = new \PayPal\Api\AgreementStateDescriptor();
            $agreementStateDescriptor->setNote("Cancel the agreement");

            try {
                $agreement->cancel($agreementStateDescriptor, $this->apiContext);
                $cancelAgreementDetails = \PayPal\Api\Agreement::get($agreement->getId(), $this->apiContext); 
                payment_delete_supscription($subscription_id);
                return true;               
            } catch (Exception $e) {
                return false;
            }
        }

        return false;
    }
}
