<?php
namespace Core\Whatsapp_api\Controllers;

class Whatsapp_api extends \CodeIgniter\Controller
{
    public function __construct(){
        $this->config = parse_config( include realpath( __DIR__."/../Config.php" ) );
        $this->model = new \Core\Whatsapp_api\Models\Whatsapp_apiModel();
    }
    
    public function index( $page = false ) {
        if(!permission("whatsapp_api")){
            redirect_to( base_url() );
        }

        $data = [
            "title" => $this->config['name'],
            "desc" => $this->config['desc'],
        ];

        $team_id = get_team("id");
        $accounts = db_fetch("*", TB_ACCOUNTS, [ "social_network" => "whatsapp", "category" => "profile", "login_type" => 2, "team_id" => $team_id, "status" => 1], "created", "ASC");
        permission_accounts($accounts);

        $data_content = [
            "config" => $this->config,
            "accounts" => $accounts
        ];

        $data['content'] = view('Core\Whatsapp_api\Views\content', $data_content );

        return view('Core\Whatsapp\Views\index', $data);
    }

    public function get_team($ids = ""){
        if($ids == ""){
            $ids = post("access_token");
        }

        if(!$ids){
            ms([
                "status" => "error",
                "message" => __("Access token is required")
            ]);
        }

        $ids = addslashes($ids);
        $item = db_get("*", TB_TEAM, ["ids" => $ids]);
        if(!$item){
            ms([
                "status" => "error",
                "message" => __("Access token does not exist")
            ]);
        }
        return $item;
    }

    public function get_instance_id($instance_id = ""){
        if($instance_id == ""){
            $instance_id = post("instance_id");
        }
        
        if(!$instance_id){
            ms([
                "status" => "error",
                "message" => __("Instance ID is required")
            ]);
        }

        return addslashes($instance_id);
    }

    public function create_instance(){
        $team = self::get_team();
        $team_id = $team->id;
        $access_token = $team->ids;
        $permissions = json_decode($team->permissions);

        //Check limit number 
        check_number_account("whatsapp", "profile", $team->id);

        $session = db_get("*", TB_WHATSAPP_SESSIONS, ["team_id" => $team_id, "status" => 0]);

        if( !$session ){
            $instance_id = strtoupper(uniqid());
            db_insert(TB_WHATSAPP_SESSIONS, [
                "ids" => ids(),
                "instance_id" => $instance_id,
                "team_id" => $team_id,
                "data" => NULL,
                "status" => 0
            ]);
        }else{
            $instance_id = $session->instance_id;
        }

        ms([
            "status" => "success",
            "message" => __("Instance ID generated successfully"),
            "instance_id" => $instance_id
        ]);
    }

    public function get_qrcode(){
        $team = self::get_team();
        $team_id = $team->id;
        $access_token = $team->ids;
        $instance_id = self::get_instance_id();

        $session = db_get("*", TB_WHATSAPP_SESSIONS, ["team_id" => $team_id, "instance_id" => $instance_id]);

        if( !$session ){
            ms([ "status" => "error", "message" => __("Instance ID Invalidated") ]);
        }

        if($session->status == 1){
            ms([ "status" => "error", "message" => __("Instance ID has been used") ]);
        }

        $result = wa_get_curl("get_qrcode", [ "instance_id" => $instance_id, "access_token" => $access_token ]);

        if($result == ""){
            ms([ "status" => "error", "message" => __("Cannot connect to WhatsApp server. Please try again later") ]);
        }

        ms((array)$result);
    }

    public function set_webhook(){
        $team = self::get_team();
        $team_id = $team->id;
        $access_token = $team->ids;
        $instance_id = self::get_instance_id();

        if( post("enable") == "" ){
            ms([ "status" => "error", "message" => __("Enable field is required") ]);
        }

        if( post("webhook_url") == "" ){
            ms([ "status" => "error", "message" => __("Webhook URL is required") ]);
        }

        $status = post("enable")=="true"?1:0;
        $webhook_url = addslashes( post("webhook_url") );

        if (!filter_var($webhook_url, FILTER_VALIDATE_URL)) {
            ms([ "status" => "error", "message" => __("Webhook URL is not a valid URL") ]);
        }

        $session = db_get("*", TB_WHATSAPP_SESSIONS, ["team_id" => $team_id, "instance_id" => $instance_id]);

        if( !$session ){
            ms([ "status" => "error", "message" => __("Instance ID Invalidated") ]);
        }

        if( $session->status == 0 ){
            ms([ "status" => "error", "message" => __("This instance ID has not been activated yet") ]);
        }
    
        $webhook = db_get("*", TB_WHATSAPP_WEBHOOK, ["team_id" => $team_id, "instance_id" => $instance_id]);

        if(!$webhook){
            db_insert( TB_WHATSAPP_WEBHOOK, [
                [
                    "ids" => ids(),
                    "instance_id" => $instance_id,
                    "team_id" => $team_id,
                    "webhook_url" => $webhook_url,
                    "status" => $status
                ]
            ]);
        }else{
            db_update( TB_WHATSAPP_WEBHOOK, [
                "webhook_url" => $webhook_url, 
                "status" => $status
            ], [
                "instance_id" => $instance_id, 
                "team_id" => $team_id
            ]);
        }   

        ms([ "status" => "success", "message" => __("Webhook URI Saved") ]);
    }

    public function reboot(){
        $team = self::get_team();
        $team_id = $team->id;
        $access_token = $team->ids;
        $instance_id = self::get_instance_id();

        if(!$instance_id){
            ms([ "status" => "error", "message" => "Instance ID Invalidated" ]);
        }

        $session = db_get("*", TB_WHATSAPP_SESSIONS, ["team_id" => $team_id, "instance_id" => $instance_id]);

        if( !$session ){
            ms([ "status" => "error", "message" => __("Instance ID Invalidated") ]);
        }

        if( $session->status == 0 ){
            ms([ "status" => "error", "message" => __("This instance ID has not been activated yet") ]);
        }

        $result = wa_get_curl("logout", [ "instance_id" => $instance_id, "access_token" => $access_token ]);

        if($result == ""){
            ms([ "status" => "error", "message" => __("Cannot connect to WhatsApp server. Please try again later") ]);
        }

        ms((array)$result);
    }

    public function reset_instance(){
        $team = self::get_team();
        $team_id = $team->id;
        $access_token = $team->ids;
        $instance_id = self::get_instance_id();

        $account = db_get("*", TB_ACCOUNTS, ["team_id" => $team_id, "token" => $instance_id]);

        if(empty($account)){
            ms([ "status" => "error", "message" => __("Account does not exist") ]);
        }

        $result = wa_get_curl("logout", [ "instance_id" => $instance_id, "access_token" => $access_token ]);
        if($result == ""){
            ms([ "status" => "error", "message" => __("Cannot connect to WhatsApp server. Please try again later") ]);
        }

        db_delete(TB_ACCOUNTS, ["id" => $account->id]);
        db_delete(TB_WHATSAPP_AUTORESPONDER, ["instance_id" => $instance_id]);
        db_delete(TB_WHATSAPP_CHATBOT, ["instance_id" => $instance_id]);
        db_delete(TB_WHATSAPP_SESSIONS, ["instance_id" => $instance_id]);
        db_delete(TB_WHATSAPP_WEBHOOK, ["instance_id" => $instance_id]);

        ms([ "status" => "success", "message" => "Reset Instance ID was successful" ]);
    }

    public function reconnect(){
        $team = self::get_team();
        $team_id = $team->id;
        $access_token = $team->ids;
        $instance_id = self::get_instance_id();

        $session = db_get("*", TB_WHATSAPP_SESSIONS, ["team_id" => $team_id, "instance_id" => $instance_id]);

        if( !$session ){
            ms([ "status" => "error", "message" => __("Instance ID Invalidated") ]);
        }

        if( $session->status == 0 ){
            ms([ "status" => "error", "message" => __("This instance ID has not been activated yet") ]);
        }

        $result = wa_get_curl("instance", [ "instance_id" => $instance_id, "access_token" => $access_token ]);
        if($result == ""){
            ms([ "status" => "error", "message" => __("Cannot connect to WhatsApp server. Please try again later") ]);
        }

        ms((array)$result);
    }

    public function send(){
        $json = file_get_contents('php://input');

        if(!empty($json)){
            $json = json_decode($json);
        }

        $team_id = "";
        $instance_id = "";
        $access_token = "";
        $type = post("type");
        $message = post("message");
        $filename = post("filename");
        $media_url = post("media_url");
        $number = post("number");

        if( !empty($json) && isset($json->number) ) $number = $json->number;
        if( !empty($json) && isset($json->media_url) ) $media_url = $json->media_url;
        if( !empty($json) && isset($json->filename) ) $filename = $json->filename;
        if( !empty($json) && isset($json->message) ) $message = $json->message;
        if( !empty($json) && isset($json->type) ) $type = $json->type;
        if( !empty($json) && isset($json->instance_id) ) $instance_id = $json->instance_id;
        if( !empty($json) && isset($json->access_token) ) $access_token = $json->access_token;

        $team = self::get_team($access_token);
        $team_id = $team->id;
        $access_token = $team->ids;
        $instance_id = self::get_instance_id($instance_id);
        
        $session = db_get("*", TB_WHATSAPP_SESSIONS, ["team_id" => $team_id, "instance_id" => $instance_id]);

        if( !$session ){
            ms([ "status" => "error", "message" => __("Instance ID Invalidated") ]);
        }

        if( $session->status == 0 ){
            ms([ "status" => "error", "message" => __("This instance ID has not been activated yet") ]);
        }

        $account = db_get("*", TB_ACCOUNTS, ["team_id" => $team_id, "token" => $instance_id]);

        if(!$account){
            ms([ "status" => "error", "message" => __("Account does not exist") ]);
        }

        if( $account->status == 0 ){
            ms([ "status" => "error", "message" => "This WhatsApp account relogin required" ]);
        }

        if($number == ""){
            ms([ "status" => "error", "message" => __("Phone number is required") ]);
        }

        if($media_url == "" && $message == ""){
            ms([ "status" => "error", "message" => __("Please enter media url or message") ]);
        }

        $response = wa_post_curl("send_message", [
            "instance_id" => $instance_id, 
            "access_token" => $access_token
        ], [
            "media_url" => $media_url,
            "chat_id" => $number."@c.us",
            "caption" => $message,
            "filename" => $filename
        ] );

        ms((array)$response);
    }

    public function send_group(){
        $json = file_get_contents('php://input');

        if(!empty($json)){
            $json = json_decode($json);
        }

        $team_id = 0;
        $instance_id = "";
        $access_token = "";
        $type = post("type");
        $message = post("message");
        $filename = post("filename");
        $media_url = post("media_url");
        $number = post("group_id");

        if( !empty($json) && isset($json->number) ) $number = $json->number;
        if( !empty($json) && isset($json->media_url) ) $media_url = $json->media_url;
        if( !empty($json) && isset($json->filename) ) $filename = $json->filename;
        if( !empty($json) && isset($json->message) ) $message = $json->message;
        if( !empty($json) && isset($json->type) ) $type = $json->type;
        if( !empty($json) && isset($json->instance_id) ) $instance_id = $json->instance_id;
        if( !empty($json) && isset($json->access_token) ) $access_token = $json->access_token;

        $team = self::get_team($access_token);
        $team_id = $team->id;
        $access_token = $team->ids;
        $instance_id = self::get_instance_id($instance_id);

        $session = db_get("*", TB_WHATSAPP_SESSIONS, ["team_id" => $team_id, "instance_id" => $instance_id]);

        if( !$session ){
            ms([ "status" => "error", "message" => __("Instance ID Invalidated") ]);
        }

        if( $session->status == 0 ){
            ms([ "status" => "error", "message" => __("This instance ID has not been activated yet") ]);
        }

        $account = db_get("*", TB_ACCOUNTS, ["team_id" => $team_id, "token" => $instance_id]);

        if(!$account){
            ms([ "status" => "error", "message" => __("Account does not exist") ]);
        }

        if( $account->status == 0 ){
            ms([ "status" => "error", "message" => "This WhatsApp account relogin required" ]);
        }
 
        $response = wa_post_curl("send_message", [
            "instance_id" => $instance_id, 
            "access_token" => $access_token
        ], [
            "media_url" => $media_url,
            "chat_id" => $number,
            "caption" => $message,
            "filename" => $filename
        ] );

        ms((array)$response);
    }

    public function logout(){
        echo "logout";
    }
}