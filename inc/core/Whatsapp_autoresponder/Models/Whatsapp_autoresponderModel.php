<?php
namespace Core\Whatsapp_autoresponder\Models;
use CodeIgniter\Model;

class Whatsapp_autoresponderModel extends Model
{
	public function __construct(){
        $this->config = parse_config( include realpath( __DIR__."/../Config.php" ) );
    }

    public function block_plans(){
        return [
            "tab" => 15,
            "position" => 300,
            "label" => __("Whatsapp tool"),
            "items" => [
                [
                    "id" => $this->config['id'],
                    "name" => $this->config['name'],
                ],
            ]
        ];
    }

    public function block_whatsapp(){
        return array(
            "position" => 5000,
            "config" => $this->config
        );
    }
}
