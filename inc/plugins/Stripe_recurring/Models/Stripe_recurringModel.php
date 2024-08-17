<?php
namespace Plugins\Stripe_recurring\Models;
use CodeIgniter\Model;

class Stripe_recurringModel extends Model
{
	public function __construct(){
        $this->config = parse_config( include realpath( __DIR__."/../Config.php" ) );
        include get_module_dir( __DIR__ , 'Libraries/vendor/autoload.php');
    }

    public function payment_button(){
        $data = [
            "title" => __("Credit card"),
            "desc" => __("Recurring payment"),
            "logo" => get_module_path(__DIR__, "Assets/img/logo.png"),
            "url" => base_url( $this->config['id']. "/index/" . uri("segment", 3) )
        ];

        return [
            'position' => 10000,
            'html' => view( 'Plugins\Stripe_recurring\Views\button', $data )
        ];
    }

    public function cancel_subscription(){
        $subscription_id = get_user_data("subscription_id", "");
        $publishable_key = get_option("stripe_publishable_key", "");
        $secret_key = get_option("stripe_secret_key", "");
        $webhook_id = get_option("stripe_webhook_id");

        if( get_option("stripe_recurring_status") && $publishable_key && $secret_key && $webhook_id && $subscription_id){

            try {
                \Stripe\Stripe::setApiKey( $secret_key );
                $subscription = \Stripe\Subscription::retrieve($subscription_id);
                $subscription->delete();
                payment_delete_supscription($subscription_id);
                return true;
            } catch (\Exception $e) {
                return false;
            }
        }

        return false;
    }
}
