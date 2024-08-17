<?php
namespace Core\Whatsapp_profile\Models;
use CodeIgniter\Model;

class Whatsapp_profileModel extends Model
{
	public function __construct(){
        $this->config = parse_config( include realpath( __DIR__."/../Config.php" ) );
    }

    public function block_plans(){
        return [
            "tab" => 15,
            "position" => 700,
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
            "position" => 3000,
            "config" => $this->config,
        );
    }
}
