<?php
namespace Plugins\Payment\Models;
use CodeIgniter\Model;

class PaymentModel extends Model
{
	public function __construct(){
        $this->config = parse_config( include realpath( __DIR__."/../Config.php" ) );
    }

    public function block_topbar($path = ""){
        return array(
            "position" => 8000,
            "topbar" => view( 'Plugins\Payment\Views\topbar', [ 'config' => $this->config ] )
        );
    }

    public function payment_configuration(){
        return [
            'position' => 1000,
            'html' => view( 'Plugins\Payment\Views\payment_configuration', [ 'config' => $this->config ] )
        ];
    }

    public function block_settings($path = ""){

        $configs = get_blocks("payment_configuration", false);

        $items = [];
        if( ! empty($configs) ){
            $items = $configs;
            if( count($items) >= 2 ){
                usort($items, function($a, $b) {
                    if( isset($a['data']['position']) &&  isset($b['data']['position']) )
                        return $a['data']['position'] <=> $b['data']['position'];
                });
            }
        }

        return array(
            "position" => 9350,
            "menu" => view( 'Plugins\Payment\Views\settings\menu', [ 'config' => $this->config ] ),
            "content" => view( 'Plugins\Payment\Views\settings\content', [ 'config' => $this->config, "items" => $items ] )
        );
    }
}
