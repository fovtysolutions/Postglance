<?php
namespace Core\Whatsapp\Controllers;

class Whatsapp extends \CodeIgniter\Controller
{
    public function __construct(){
        $this->config = parse_config( include realpath( __DIR__."/../Config.php" ) );
        $this->model = new \Core\Whatsapp\Models\WhatsappModel();
    }
    
    public function index( $page = false ) {
        $report = $this->model->block_dashboard();
        $data['content'] = view('Core\Whatsapp\Views\content', ['content' => $report['html']] );

        return view('Core\Whatsapp\Views\index', $data);
    }

    public function sidebar(){
        $modules = $this->model->get_modules();
        $data = [
            "title" => $this->config['name'],
            "desc" => $this->config['desc'],
            "modules" => $modules,
        ];
        return view('Core\Whatsapp\Views\sidebar', $data);
    }

    public function widget_content( $params = [] ){
        if ( !permission("whatsapp_send_media") ) return "";
        return view('Core\Whatsapp\Views\widget\content', ["result" => $params["result"]]);
    }

    public function logout($ids = false){
        $team_id = get_team("id");
        $access_token = get_team("ids");
        $account = db_get("*", TB_ACCOUNTS, ["ids" => $ids, "team_id" => $team_id]);

        if(!$account){
            ms([
                "status" => "error",
                "message" => __("Account does not exist")
            ]);
        }

        $result = wa_get_curl("logout", [ "instance_id" => $account->token, "access_token" => $access_token ]);
        if($result == ""){
            ms([
                "status" => "error",
                "message" => __("Cannot connect WhatsApp server")
            ]);
        }

        ms([
            "status" => $result->status,
            "message" => $result->message
        ]);
    }

    public function reset_plan($user_id = 0){
        if( get_user("is_admin") ){

            $team = db_get("id", TB_TEAM, ["owner" => $user_id]);
            if(!$team){
                ms([
                    "status" => "error",
                    "message" => __("User does not exist")
                ]);
            }

            $stats = db_get("*", TB_WHATSAPP_STATS, ["team_id" => $team->id]);
            if(!$stats){
                ms([
                    "status" => "error",
                    "message" => __("Account does not exist")
                ]);
            }

            db_update(TB_WHATSAPP_STATS, [
                "wa_total_sent_by_month" => 0,
                "wa_time_reset" => 0,
                "next_update" => 0
            ], [ "team_id" => $team->id ]);

            ms([
                "status" => 'success',
                "message" => _("Success")
            ]);
        }

        ms([
            "status" => 'success',
            "message" => _("You don't have permission to access to it")
        ]);
    }
}