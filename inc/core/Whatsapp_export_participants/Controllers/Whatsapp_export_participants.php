<?php
namespace Core\Whatsapp_export_participants\Controllers;

class Whatsapp_export_participants extends \CodeIgniter\Controller
{
    public function __construct(){
        $this->config = parse_config( include realpath( __DIR__."/../Config.php" ) );
        $this->model = new \Core\Whatsapp_export_participants\Models\Whatsapp_export_participantsModel();
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

        $data['content'] = view('Core\Whatsapp_export_participants\Views\content', $data_content );

        return view('Core\Whatsapp\Views\index', $data);
    }

    public function groups() {
        $team_id = get_team("id");
        $access_token = get_team("ids");
        $ids = post("account");
        $account = db_get("*", TB_ACCOUNTS, ["social_network" => "whatsapp", "login_type" => 2, "ids" => $ids, "team_id" => $team_id]);

        if(!empty($account)){
            $result = wa_get_curl("get_groups", [ "instance_id" => $account->token, "access_token" => $access_token ]);
            if($result->status == "error"){
                $data = [
                    "status" => "error",
                    "message" => $result->message
                ];
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

        return view('Core\Whatsapp_export_participants\Views\groups', $data);
    }

    public function export_group($account_id = false, $group_id = false){
        $team_id = get_team("id");
        $access_token = get_team("ids");
        $account = db_get("*", TB_ACCOUNTS, ["social_network" => "whatsapp", "login_type" => 2, "ids" => $account_id, "team_id" => $team_id]);

        if(!empty($account)){
            $result = wa_get_curl("get_groups", [ "instance_id" => $account->token, "access_token" => $access_token ]);

            if($result == ""){
                redirect_to( get_module_url() );
            }

            if($result->status == "error"){
                redirect_to( get_module_url() );
            }

            if(!empty( $result->data )){

                foreach ($result->data as $key => $value) {
                    if($value->id == $group_id){
                        $participants = $value->participants;

                        $data = [];
                        foreach ($participants as $participant) {
                            $data[] = [
                                'id' => $participant->id,
                                'user' => wa_get_phone($participant->id)
                            ];
                        }

                        download_send_headers($value->name." participants " . date("Y-m-d") . ".csv");
                        echo array2csv($data);
                    }
                }
            }else{
                redirect_to( get_module_url() );
            }
        }
    }
}