<?php
namespace Core\Google_business_profile_post\Controllers;

class Google_business_profile_post extends \CodeIgniter\Controller
{
    public function __construct(){
        $this->config = parse_config( include realpath( __DIR__."/../Config.php" ) );
    }
}