<?php
namespace Plugins\Coinpayments\Models;
use CodeIgniter\Model;

class CoinpaymentsModel extends Model
{
	public function __construct(){
        $this->config = parse_config( include realpath( __DIR__."/../Config.php" ) );
    }

    public function payment_configuration(){
        return [
            'position' => 3000,
            'html' => view( 'Plugins\Coinpayments\Views\payment_configuration', [ 'config' => $this->config ] )
        ];
    }

    public function payment_button(){
        $data = [
            "title" => __("Coinpayments"),
            "desc" => __("One-time payment"),
            "logo" => get_module_path(__DIR__, "Assets/img/logo.png"),
            "url" => base_url( $this->config['id']. "/index/" . uri("segment", 3) )
        ];

        return [
            'position' => 11000,
            'html' => view( 'Plugins\Coinpayments\Views\button', $data )
        ];
    }
}
