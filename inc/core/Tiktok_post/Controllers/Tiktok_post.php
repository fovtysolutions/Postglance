<?php
namespace Core\Tiktok_post\Controllers;

class Tiktok_post extends \CodeIgniter\Controller
{
    public function __construct(){
        $this->config = parse_config( include realpath( __DIR__."/../Config.php" ) );
    }
}