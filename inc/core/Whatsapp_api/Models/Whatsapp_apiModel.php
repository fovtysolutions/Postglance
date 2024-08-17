<?php
namespace Core\Whatsapp_api\Models;
use CodeIgniter\Model;

class Whatsapp_apiModel extends Model
{
	public function __construct(){
        $this->config = parse_config( include realpath( __DIR__."/../Config.php" ) );
    }

    public function block_plans(){
        return [
            "tab" => 15,
            "position" => 400,
            "label" => __("Whatsapp tool"),
            "items" => [
                [
                    "id" => $this->config['id'],
                    "name" => __("REST API"),
                ],
            ]
        ];
    }

    public function block_whatsapp(){
        return array(
            "position" => 9000,
            "config" => $this->config
        );
    }
}
