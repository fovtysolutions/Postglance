<?php
namespace Core\Pinterest_post\Controllers;

class Pinterest_post extends \CodeIgniter\Controller
{
    public function __construct(){
        $this->config = parse_config( include realpath( __DIR__."/../Config.php" ) );
    }
}