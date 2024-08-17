<?php
namespace Plugins\Stripe\Models;
use CodeIgniter\Model;

class StripeModel extends Model
{
	public function __construct(){
        $this->config = parse_config( include realpath( __DIR__."/../Config.php" ) );
    }

    public function payment_configuration(){
        return [
            'position' => 2000,
            'html' => view( 'Plugins\Stripe\Views\payment_configuration', [ 'config' => $this->config ] )
        ];
    }

    public function payment_button(){
        $data = [
            "title" => __("Credit card"),
            "desc" => __("One-time payment"),
            "logo" => get_module_path(__DIR__, "Assets/img/logo.png"),
            "url" => base_url( $this->config['id']. "/index/" . uri("segment", 3) )
        ];

        return [
            'position' => 10000,
            'html' => view( 'Plugins\Stripe\Views\button', $data )
        ];
    }
}
