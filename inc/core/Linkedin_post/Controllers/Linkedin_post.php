<?php
namespace Core\Linkedin_post\Controllers;

class Linkedin_post extends \CodeIgniter\Controller
{
    public function __construct(){
        $this->config = parse_config( include realpath( __DIR__."/../Config.php" ) );
    }
}