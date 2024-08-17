<?php
namespace Core\Whatsapp\Models;
use CodeIgniter\Model;

class WhatsappModel extends Model
{
	public function __construct(){
        $this->config = parse_config( include realpath( __DIR__."/../Config.php" ) );
    }

    public function block_permissions($path = ""){
        return view( 'Core\Whatsapp\Views\permissions', [ 'config' => $this->config ] );
    }

    public function block_action_user($path = ""){
        return view( 'Core\Whatsapp\Views\action_user', [ 'config' => $this->config ] );
    }

    public function block_plans(){
        return [
            "tab" => 15,
            "position" => 800,
            "label" => __("Whatsapp tool"),
            "items" => [
                [
                    "id" => $this->config['id'],
                    "name" => $this->config['name'],
                ],
            ]
        ];
    }

    public function block_whatsapp(){
        return array(
            "position" => 1000,
            "config" => $this->config
        );
    }

    public function block_dashboard($path = ""){

        $team_id = get_team("id");

        $wa_total_sent_by_month = 0;
        $wa_total_sent = 0;
        $wa_bulk_total_count = 0;
        $wa_bulk_sent_count = 0;
        $wa_bulk_failed_count = 0;
        $wa_autoresponder_count = 0;
        $wa_chatbot_count = 0;
        $wa_api_count = 0;

        $stats = db_get("*", TB_WHATSAPP_STATS, ["team_id" => $team_id]);

        if( !empty($stats) ){
            $wa_total_sent_by_month = (int)$stats->wa_total_sent_by_month;
            $wa_total_sent = (int)$stats->wa_total_sent;
            $wa_bulk_total_count = (int)$stats->wa_bulk_total_count;
            $wa_bulk_sent_count = (int)$stats->wa_bulk_sent_count;
            $wa_bulk_failed_count = (int)$stats->wa_bulk_failed_count;
            $wa_autoresponder_count = (int)$stats->wa_autoresponder_count;
            $wa_chatbot_count = (int)$stats->wa_chatbot_count;
            $wa_api_count = (int)$stats->wa_api_count;
        }

        $bulks = db_fetch("*", TB_WHATSAPP_SCHEDULES, ["team_id" => $team_id], "id", "DESC", 0, 20);

        $autoresponders = false;
        $db = \Config\Database::connect();
        $builder = $db->table(TB_WHATSAPP_AUTORESPONDER." as a");
        $builder->select("a.*, b.id as account_id, b.name as account_name, b.username as account_username");
        $builder->join(TB_ACCOUNTS. " as b", "a.instance_id = b.token");
        $builder->where("a.team_id", $team_id);
        $builder->orderBy("b.id", "ASC");
        $autoresponder_query = $builder->get();
        if($autoresponder_query){
            $autoresponders = $autoresponder_query->getResult();
        }

        $chatbots = [];
        $chatbot_items = false;
        $db = \Config\Database::connect();
        $builder = $db->table(TB_WHATSAPP_CHATBOT." as a");
        $builder->select("
            a.instance_id,
            a.id,
            a.ids,
            a.name,
            a.keywords,
            a.sent, 
            a.failed, 
            b.id as account_id, 
            b.name as account_name, 
            b.username as account_username
        ");
        $builder->join(TB_ACCOUNTS. " as b", "a.instance_id = b.token");
        $builder->where("a.team_id", $team_id);
        $builder->orderBy("b.id", "ASC");
        $chatbot_query = $builder->get();
        if($chatbot_query){
            $chatbot_items = $chatbot_query->getResult();

            if($chatbot_items){
                foreach ($chatbot_items as $key => $value) {
                    if ( !isset($chatbots[$value->instance_id]) ) {
                        $chatbots[$value->instance_id] = $value;
                    }else{
                        $chatbots[$value->instance_id]->sent += $value->sent;
                        $chatbots[$value->instance_id]->failed += $value->failed;
                    }
                }
            }
        }

        $data = [
            "wa_total_sent" => $wa_total_sent,
            "wa_total_sent_by_month" => $wa_total_sent_by_month,
            "wa_bulk_total_count" => $wa_bulk_total_count,
            "wa_bulk_sent_count" => $wa_bulk_sent_count,
            "wa_bulk_failed_count" => $wa_bulk_failed_count,
            "wa_autoresponder_count" => $wa_autoresponder_count,
            "wa_chatbot_count" => $wa_chatbot_count,
            "wa_api_count" => $wa_api_count,
            "bulks" => $bulks,
            "chatbots" => $chatbots,
            "autoresponders" => $autoresponders,
            "config" => $this->config
        ];

        return [
            "position" => 3000,
            "html" =>  view( 'Core\Whatsapp\Views\report', $data)
        ];
    }

    public function get_modules(){
        $module_paths = get_module_paths();
        $modules_data_feature = array();
        $modules_data_teplate = array();
        $modules_data_contact = array();

        if(!empty($module_paths))
        {
            if( !empty($module_paths) ){
                foreach ($module_paths as $key => $module_path) {
                    $model_paths = $module_path . "/Models/";
                    $model_files = glob( $model_paths . '*' );


                    if ( !empty( $model_files ) )
                    {
                        foreach ( $model_files as $model_file )
                        {
                            $model_content = get_all_functions($model_file);
                            if ( in_array("block_whatsapp", $model_content) )
                                {   
                                $config_path = $module_path . "/Config.php";
                                $config_item = include $config_path;
                                include_once $model_file;
                                
                                $class = str_replace(COREPATH, "\\", $model_file);
                                $class = str_replace(".php", "", $class);
                                $class = str_replace("/", "\\", $class);
                                $class = ucfirst($class);
                                
                                $data = new $class;
                                $name = explode("\\", $class);
                                switch ( strtolower( $config_item['parent']['id']) ) {
                                    case 'features':
                                        $modules_data_feature[] = $data->block_whatsapp();
                                        break;

                                    case 'template':
                                        $modules_data_teplate[] = $data->block_whatsapp();
                                        break;
                                    
                                    case 'contact':
                                        $modules_data_contact[] = $data->block_whatsapp();
                                        break;
                                }
                            }
                        }
                    }
                }
            }
        }

        if( !empty($modules_data_feature) || !empty($modules_data_teplate) || !empty($modules_data_contact)){
            if(!empty($modules_data_feature)){
                uasort($modules_data_feature, function($a, $b) {
                    return $a['position'] <=> $b['position'];
                });
            }

            if(!empty($modules_data_teplate)){
                uasort($modules_data_teplate, function($a, $b) {
                    return $a['position'] <=> $b['position'];
                });
            }

            if(!empty($modules_data_contact)){
                uasort($modules_data_contact, function($a, $b) {
                    return $a['position'] <=> $b['position'];
                });
            }

            $modules_data = [];
            $modules_data[] = $modules_data_feature;
            $modules_data[] = $modules_data_teplate;
            $modules_data[] = $modules_data_contact;

            return $modules_data;
        }

        return false;
    }
}
