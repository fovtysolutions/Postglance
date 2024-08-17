<?php
namespace Core\Telegram_post\Controllers;

class Telegram_post extends \CodeIgniter\Controller
{
    public function __construct(){
        $this->config = parse_config( include realpath( __DIR__."/../Config.php" ) );
    }
}