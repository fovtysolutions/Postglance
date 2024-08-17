<?php
namespace Core\Whatsapp_autoresponder\Controllers;

class Whatsapp_autoresponder extends \CodeIgniter\Controller
{
    public function __construct(){
        $this->config = parse_config( include realpath( __DIR__."/../Config.php" ) );
        $this->model = new \Core\Whatsapp_autoresponder\Models\Whatsapp_autoresponderModel();
    }
    
    public function index( $page = false ) {
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

        $data['content'] = view('Core\Whatsapp_autoresponder\Views\content', $data_content );

        return view('Core\Whatsapp\Views\index', $data);
    }

    public function info() {
        $team_id = get_team("id");
        $access_token = get_team("ids");
        $ids = post("account");
        $account = db_get("*", TB_ACCOUNTS, ["social_network" => "whatsapp", "login_type" => 2, "ids" => $ids, "team_id" => $team_id]);

        if(!empty($account) || $ids == "all"){
            $result = false;
            if( !empty($account) ){
                $result = db_get("*", TB_WHATSAPP_AUTORESPONDER, [ "instance_id" => $account->token, "team_id" => $team_id ]);
            }

            $data = [
                "status" => "success",
                "result" => $result,
                "account" => $account,
                "access_token" => $access_token,
            ];

        }else{
            $data = [
                "status" => "error",
                "message" => "WhatsApp account does not exist. Please try again or re-login your WhatsApp account"
            ];

        }

        return view('Core\Whatsapp_autoresponder\Views\info', $data);
    }

    public function save(){
        $team_id = get_team("id");
        $status = (int)post('status');
        $medias = post("medias");
        $advance_options = post("advance_options");
        $caption = post('caption');
        $delay = post('delay');
        $instance_id = post('instance_id');
        $except = post('except');
        $send_to = (int)post('send_to');
        $type = (int)post("type");
        $template = 0;
        $btn_msg = (int)post("btn_msg");
        $list_msg = (int)post("list_msg");
        $account = false;

        validate('null', __('Delay'), $delay);

        if($instance_id != ""){
            $account = db_get("*", TB_ACCOUNTS, ["token" => $instance_id, "team_id" => $team_id]);

            if(empty($account)){
                ms([
                    "status" => "error",
                    "message" => __('Profile does not exist')
                ]);
            }
        }

        switch ($type) {
            case 1:
                if( permission("whatsapp_send_media") ){
                    if(!is_array($medias) && $caption == ""){
                        ms([
                            "status" => "error",
                            "message" => __('Please enter a caption or add a media')
                        ]);
                    }
                }else{
                    validate('null', __('Caption'), $caption);
                }
                break;

            case 2:
                if($btn_msg == 0){
                    ms([
                        "status" => "error",
                        "message" => __('Please select a button message option')
                    ]);
                }
                $template = $btn_msg;
                break;

            case 3:
                if($list_msg == 0){
                    ms([
                        "status" => "error",
                        "message" => __('Please select a list message option')
                    ]);
                }

                $template = $list_msg;
                break;
            
            default:
                if($btn_msg == 0){
                    ms([
                        "status" => "error",
                        "message" => __('Invalid input data')
                    ]);
                }
                break;
        }

        if(!empty($medias) && permission("whatsapp_send_media")){
            foreach ($medias as $key => $value) {
                $medias[$key] = get_file_url($value);
            }

            $media = $medias[0];
        }else{
            $media = NULL;
        }

        if((int)permission("whatsapp_autoresponser_delay") > (int)$delay){
            ms([
                "status" => "error",
                "message" => sprintf( __('You can only set autoresponder delays greater than %s minutes'), (int)permission("whatsapp_autoresponser_delay") )
            ]);
        }

        if(!empty($advance_options) && isset($advance_options['shortlink'])){
            $shortlink_by = shortlink_by(['advance_options' => [ 'shortlink' => $advance_options['shortlink'] ]]);
            $caption = shortlink($caption, $shortlink_by);
        }

        if(!empty($account)){
            $item = db_get("*", TB_WHATSAPP_AUTORESPONDER, ["ids" => $account->ids, "team_id" => $team_id]);

            if(!$item ){
                db_insert(TB_WHATSAPP_AUTORESPONDER , [
                    "team_id" => $team_id,
                    "ids" => $account->ids,
                    "type" => $type,
                    "template" => $template,
                    "instance_id" => $account->token,
                    "caption" => $caption,
                    "media" => $media,
                    "except" => $except,
                    "delay" => $delay,
                    "send_to" => $send_to,
                    "status" => $status,
                    "changed" => time(),
                    "created" => time()
                ]);
            }else{
                db_update(
                    TB_WHATSAPP_AUTORESPONDER, 
                    [
                        "team_id" => $team_id,
                        "type" => $type,
                        "template" => $template,
                        "instance_id" => $account->token,
                        "caption" => $caption,
                        "media" => $media,
                        "except" => $except,
                        "delay" => $delay,
                        "send_to" => $send_to,
                        "status" => $status,
                        "changed" => time()
                    ], 
                    ["ids" => $account->ids]
                );
            }
        }else{
            $accounts = db_fetch("*", TB_ACCOUNTS, [ "social_network" => "whatsapp", "login_type" => 2, "team_id" => $team_id]);
            foreach ($accounts as $key => $account) {
                $item = db_get("*", TB_WHATSAPP_AUTORESPONDER, ["ids" => $account->ids, "team_id" => $team_id]);
                if(!$item ){
                    db_insert(TB_WHATSAPP_AUTORESPONDER , [
                        "team_id" => $team_id,
                        "ids" => $account->ids,
                        "type" => $type,
                        "template" => $template,
                        "instance_id" => $account->token,
                        "caption" => $caption,
                        "media" => $media,
                        "except" => $except,
                        "delay" => $delay,
                        "send_to" => $send_to,
                        "status" => $status,
                        "changed" => time(),
                        "created" => time()
                    ]);
                }else{
                    db_update(
                        TB_WHATSAPP_AUTORESPONDER, 
                        [
                            "team_id" => $team_id,
                            "type" => $type,
                            "template" => $template,
                            "instance_id" => $account->token,
                            "caption" => $caption,
                            "media" => $media,
                            "except" => $except,
                            "delay" => $delay,
                            "send_to" => $send_to,
                            "status" => $status,
                            "changed" => time()
                        ], 
                        ["ids" => $account->ids]
                    );
                }
            }
        }

        ms([
            "status" => "success",
            "message" => __('Success')
        ]);
    }
}