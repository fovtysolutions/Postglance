<?php
$config = include realpath( __DIR__."/../Config.php" );
if (!defined('MODULE_CONFIG')){
    define("MODULE_CONFIG", $config);
}

if(
    isset($config['menu']) && 
    isset($config['menu']['sub_menu']) && 
    isset($config['menu']['sub_menu']["id"]) && 
    (url_is( $config['menu']['sub_menu']["id"] ) || url_is( $config['menu']['sub_menu']["id"].'/*' )) 
){
    $routes->setDefaultNamespace( ucfirst($config['folder']) . "/" . ucfirst($config['menu']['sub_menu']["id"]) . "/Controllers");
}else if( url_is( $config["id"] ) || url_is( $config["id"].'/*' ) ){
    $routes->setDefaultNamespace( ucfirst($config['folder']) . "/" . ucfirst($config['id']) . "/Controllers");
}

$routes->group('', ['namespace' => 'Core\Whatsapp_api\Controllers'], static function ($routes) {
    $routes->get('api/create_instance', 'Whatsapp_api::create_instance');
    $routes->get('api/get_qrcode', 'Whatsapp_api::get_qrcode');
    $routes->get('api/set_webhook', 'Whatsapp_api::set_webhook');
    $routes->get('api/reboot', 'Whatsapp_api::reboot');
    $routes->get('api/reset_instance', 'Whatsapp_api::reset_instance');
    $routes->get('api/reconnect', 'Whatsapp_api::reconnect');
    $routes->post('api/send', 'Whatsapp_api::send');
    $routes->get('api/send', 'Whatsapp_api::send');
    $routes->get('api/send_group', 'Whatsapp_api::send_group');
    $routes->post('api/send_group', 'Whatsapp_api::send_group');
    $routes->get('api/logout', 'Whatsapp_api::logout');
});

if ( file_exists( realpath(  __DIR__."/../Helpers" ) ) ) {
    $helperPath = realpath(  __DIR__."/../Helpers/" )."/";
    $helpers = scandir($helperPath);
    foreach ($helpers as $helper) {
        if ($helper === '.' || $helper === '..' || stripos( $helper , "_helper.php") === false) continue;
        if (  file_exists( $helperPath.$helper ) ) {
            require_once( $helperPath.$helper );
        }
    }
}