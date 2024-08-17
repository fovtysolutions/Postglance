<?php
namespace Core\Whatsapp_profiles\Controllers;

class Whatsapp_profiles extends \CodeIgniter\Controller
{
    public function __construct(){
        $reflect = new \ReflectionClass(get_called_class());
        $this->module = strtolower( $reflect->getShortName() );
        $this->config = include realpath( __DIR__."/../Config.php" );
        $this->whatsapp_server_url = get_option('whatsapp_server_url', '');

        if($this->whatsapp_server_url == ""){
            redirect_to( base_url("social_network_settings/index/".$this->config['parent']['id']) ); 
        }
    }
    
    public function index() {
        redirect_to( get_module_url("oauth") );
    }

    public function oauth($instance_id = false){
        $team_id = get_team("id");
        $content_data = [ "config" => $this->config ];

        $account = db_get("*", TB_ACCOUNTS, ["social_network" => "whatsapp", "category" => "profile", "token" => $instance_id, "team_id" => $team_id]);
        $accounts = db_fetch("*", TB_ACCOUNTS, ["social_network" => "whatsapp", "category" => "profile", "team_id" => $team_id, "status" => 0]);
        $content_data['accounts'] = $accounts;

        if(empty($account)){
            $session = db_get("*", TB_WHATSAPP_SESSIONS,["status" => 0, "team_id" => $team_id]);
            if(empty($session)){
                $instance_id = strtoupper(uniqid());
                db_delete(TB_WHATSAPP_SESSIONS, ["status" => 0, "team_id" => $team_id]);
                db_insert( TB_WHATSAPP_SESSIONS, [
                    "ids" => ids(),
                    "instance_id" => $instance_id,
                    "team_id" => $team_id,
                    "data" => NULL,
                    "status" => 0
                ] );

                $content_data['instance_id'] = $instance_id;
            }else{
                $content_data['instance_id'] = $session->instance_id;
            }
        }else{
            db_update(TB_WHATSAPP_SESSIONS, [ 'status' => 0], [ 'instance_id' => $account->token ]);
            $content_data['instance_id'] = $instance_id;
        }

        $data = [
            "title" => $this->config['name'],
            "desc" => $this->config['desc'],
            "config" => $this->config,
            "content" => view('Core\Whatsapp_profiles\Views\oauth', $content_data)
        ];

        return view('Core\Whatsapp_profiles\Views\index', $data);
    }

    public function get_qrcode($instance_id = false){
        $team_id = get_team("id");
        $access_token = get_team("ids");

        $account = db_get("*", TB_ACCOUNTS, ["social_network" => "whatsapp", "category" => "profile", "token" => $instance_id, "team_id" => $team_id]);
        if($account){
            $session = db_get("*", TB_WHATSAPP_SESSIONS, ["team_id" => $team_id, "status" => 0]);
            if($session){
                if($session->instance_id != $instance_id){
                    db_update( TB_WHATSAPP_SESSIONS, [
                        "instance_id" => $instance_id,
                        "status" => 0
                    ], [ 'id' => $session->id ] );
                }
            }else{
                db_insert( TB_WHATSAPP_SESSIONS, [
                    "ids" => ids(),
                    "instance_id" => $instance_id,
                    "team_id" => $team_id,
                    "data" => NULL,
                    "status" => 0
                ] );
            }
        }else{
            if(!check_number_account("whatsapp", "profile", false, false)){
                return false;
            }
        }

        $result = wa_get_curl("get_qrcode", [ "instance_id" => $instance_id, "access_token" => $access_token ]);
        if($result == "") return false;

        if( $result->status == "error" ){
            ms([
                "status" => "error",
                "message" => __( $result->message )
            ]);
        }else{
            header("Content-type: image/png");
            echo base64_decode( str_replace("data:image/png;base64,", "", $result->base64) );
        }
    }

    public function check_login($instance_id = ""){
        $team_id = get_team("id");
        $whatsapp_session = db_get("*", TB_WHATSAPP_SESSIONS, ["status" => 1, "team_id" => $team_id, "instance_id" => $instance_id]);
        
        if($whatsapp_session){

            $profile = false;
            if($whatsapp_session->data != ""){
                $profile = json_decode($whatsapp_session->data);
            }

            $account = db_get("*", TB_ACCOUNTS, ["token" => $instance_id, "team_id" => $team_id]);

            if(!$account){
                $account = db_get("*", TB_ACCOUNTS, ["pid" => $profile->id, "team_id" => $team_id]);
            }

            if($account){
                $avatar = save_img( $account->avatar, WRITEPATH.'avatar/' );
                db_update(TB_ACCOUNTS, ["avatar" => $avatar], ['id' => $account->id]);
                
                ms([
                    "status" => "success",
                    "message" => __("Success")
                ]);
            }
        }

        ms([
            "status" => "error",
            "message" => __("Unsuccess")
        ]);
    }

    public function delete(){
        $ids = post('id');
        $team_id = get_team('id');
        $access_token = get_team('ids');

        if( empty($ids) ){
            ms([
                "status" => "error",
                "message" => __('Please select an item to delete')
            ]);
        }

        if( is_array($ids) ){
            foreach ($ids as $id) {

                $account = db_get("*", TB_ACCOUNTS, ["ids" => $id, "team_id" => $team_id]);
                if($account){
                    db_delete(TB_ACCOUNTS, ['ids' => $id]);
                    db_delete(TB_WHATSAPP_AUTORESPONDER, ['instance_id' => $account->token]);
                    db_delete(TB_WHATSAPP_CHATBOT, ['instance_id' => $account->token]);
                    db_delete(TB_WHATSAPP_SESSIONS, ['instance_id' => $account->token]);
                    db_delete(TB_WHATSAPP_WEBHOOK, ['instance_id' => $account->token]);
                    wa_get_curl("logout", [ "instance_id" => $account->token, "access_token" => $access_token ]);
                }
            }
        }
        elseif( is_string($ids) )
        {
            $account = db_get("*", TB_ACCOUNTS, ["ids" => $ids, "team_id" => $team_id]);
            if(!$account){
                db_delete(TB_ACCOUNTS, ['ids' => $ids]);
                db_delete(TB_WHATSAPP_AUTORESPONDER, ['instance_id' => $account->token]);
                db_delete(TB_WHATSAPP_CHATBOT, ['instance_id' => $account->token]);
                db_delete(TB_WHATSAPP_SESSIONS, ['instance_id' => $account->token]);
                db_delete(TB_WHATSAPP_WEBHOOK, ['instance_id' => $account->token]);
                wa_get_curl("logout", [ "instance_id" => $account->token, "access_token" => $access_token ]);
            }
        }

        ms([
            "status" => "success",
            "message" => __('Success')
        ]);
    }
}