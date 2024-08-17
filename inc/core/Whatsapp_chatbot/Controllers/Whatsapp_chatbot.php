<?php
namespace Core\Whatsapp_chatbot\Controllers;

class Whatsapp_chatbot extends \CodeIgniter\Controller
{
    public function __construct(){
        $this->config = parse_config( include realpath( __DIR__."/../Config.php" ) );
        $this->model = new \Core\Whatsapp_chatbot\Models\Whatsapp_chatbotModel();
    }
    
    public function index( $page = false, $account_ids = "", $ids = "" ) {
        $team_id = get_team("id");
        $data = [
            "title" => $this->config['name'],
            "desc" => $this->config['desc'],
        ];

        switch ( $page ) {
            case 'list':
                $account = db_get("*", TB_ACCOUNTS, [ "ids" => $account_ids, "team_id" => $team_id ]);
                if(!$account){
                    redirect_to( get_module_url() );
                }

                $item = db_get("*", TB_WHATSAPP_CHATBOT, [ "instance_id" => $account->token ]);
                if($item && $item->run == 1){
                    $run = 1;
                }else{
                    $run = 0;
                }

                $total = $this->model->get_list(false);

                $datatable = [
                    "total_items" => $total,
                    "per_page" => 30,
                    "current_page" => 1,

                ];

                $data_content = [
                    'run' => $run,
                    'account' => $account,
                    'total' => $total,
                    'datatable'  => $datatable,
                    'config'  => $this->config,
                ];

                $data['content'] = view('Core\Whatsapp_chatbot\Views\list', $data_content );
                break;

            case 'update':
                $team_id = get_team("id");
                $account = db_get("*", TB_ACCOUNTS, [ "ids" => $account_ids, "team_id" => $team_id ]);
                if(empty($account)){
                    redirect_to( get_module_url() );
                } 

                $item = false;
                if( $ids ){
                    $item = db_get("*", TB_WHATSAPP_CHATBOT, [ "ids" => $ids, "team_id" => $team_id ]);
                }

                $data['content'] = view('Core\Whatsapp_chatbot\Views\update', ["result" => $item, "account" => $account, "config" => $this->config]);
                break;

            default:
                $total = $this->model->get_list(false);

                $datatable = [
                    "total_items" => $total,
                    "per_page" => 30,
                    "current_page" => 1,

                ];

                $data_content = [
                    'total' => $total,
                    'datatable'  => $datatable,
                    'config'  => $this->config,
                ];

                $data['content'] = view('Core\Whatsapp_chatbot\Views\content', $data_content );
                break;
        }

        return view('Core\Whatsapp\Views\index', $data);
    }

    public function ajax_list(){
        $total_items = $this->model->get_list(false);
        $result = $this->model->get_list(true);
        $data = [
            "result" => $result,
            "config" => $this->config
        ];
        ms( [
            "total_items" => $total_items,
            "data" => view('Core\Whatsapp_chatbot\Views\ajax_list', $data)
        ] );
    }

    public function ajax_list_items($ids = false){
        $team_id = get_team("id");
        $account = db_get("*", TB_ACCOUNTS, ["ids" => $ids, "team_id" => $team_id]);

        $total_items = $this->model->get_list_items(false, $account->token);
        $result = $this->model->get_list_items(true, $account->token);
        $data = [
            "account" => $account,
            "result" => $result,
            "config" => $this->config
        ];
        ms( [
            "total_items" => $total_items,
            "data" => view('Core\Whatsapp_chatbot\Views\ajax_list_items', $data)
        ] );
    }

    public function save(){
        $team_id = get_team("id");
        $ids = post("ids");
        $type = (int)post("type");
        $name = post("name");
        $advance_options = post("advance_options");
        $type_search = (int)post("type_search");
        $template = 0;
        $btn_msg = (int)post("btn_msg");
        $list_msg = (int)post("list_msg");
        $keywords = post("keywords");
        $caption = post("caption");  
        $medias = post("medias");
        $send_to = (int)post('send_to');
        $status = (int)post("status");
        $instance_id = post("instance_id");
        $interval_per_post = (int)post("interval_per_post");
        $item = db_get("*", TB_WHATSAPP_CHATBOT, ["ids" => $ids, "team_id" => $team_id]);
        $account = db_get("*", TB_ACCOUNTS, ["token" => $instance_id, "team_id" => $team_id]);

        validate('null', __('Bot name'), $name);
        validate("max_length", "Bot name", $name, 100);
        validate('null', __('Keywords'), $keywords);
        validate('empty', __('Please select at least a profile'), $account);

        if( $account->status == 0 ){
            ms([
                "status" => "error",
                "message" => __("Relogin is required")
            ]);
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
                    wa_ms([
                        "status" => "error",
                        "message" => __('Invalid input data')
                    ]);
                }
                break;
        }

        $run = 0;
        $chatbot_item = db_get("*", TB_WHATSAPP_CHATBOT, ["instance_id" => $instance_id, "team_id" => $team_id]);
        if(!empty($chatbot_item) && $chatbot_item->run){
            $run = 1;
        }

        if(!empty($medias) && permission("whatsapp_send_media")){
            foreach ($medias as $key => $value) {
                $medias[$key] = get_file_url($value);
            }

            $media = $medias[0];
        }else{
            $media = NULL;
        }

        $keywords = wa_keyword_trim($keywords);

        if(!empty($advance_options) && isset($advance_options['shortlink'])){
            $shortlink_by = shortlink_by(['advance_options' => [ 'shortlink' => $advance_options['shortlink'] ]]);
            $caption = shortlink($caption, $shortlink_by);
        }
        
        if(!empty($item)){
            $data = [
                "team_id" => $team_id,
                "instance_id" => $instance_id,
                "type" => $type,
                "name" => $name,
                "type_search" => $type_search,
                "template" => $template,
                "keywords" => mb_strtolower($keywords),
                "caption" => $caption,
                "media" => $media,
                "run" => $run,
                "send_to" => $send_to,
                "status" => $status,
                "changed" => time()
            ];

            $result = db_update( TB_WHATSAPP_CHATBOT, $data, ["id" => $item->id]);
        }else{
            $chatbot_count = db_get("count(*) as count", TB_WHATSAPP_CHATBOT, ["instance_id" => $instance_id, "team_id" => $team_id])->count;
            if($chatbot_count >= (int)permission("whatsapp_chatbot_item_limit")){
                ms([
                    "status" => "error",
                    "message" => sprintf( __('You can only add a maximum of %s chatbot items.'), (int)permission("whatsapp_chatbot_item_limit"))
                ]);
            }

            $data = [
                "ids" => ids(),
                "team_id" => $team_id,
                "instance_id" => $instance_id,
                "type" => $type,
                "name" => $name,
                "type_search" => $type_search,
                "template" => $template,
                "keywords" => mb_strtolower($keywords),
                "caption" => $caption,
                "media" => $media,
                "run" => $run,
                "send_to" => $send_to,
                "status" => $status,
                "changed" => time(),
                "created" => time()
            ];

            $result = db_insert( TB_WHATSAPP_CHATBOT, $data);
        }

        ms([
            "status" => "success",
            "message" => __("Success")
        ]);
    }

    public function status( $instance_id = false ){
        $team_id = get_team('id');
        $chatbot_item = db_get("*", TB_WHATSAPP_CHATBOT, ["instance_id" => $instance_id, "team_id" => $team_id]);

        if(!$chatbot_item){
            
            ms([
                "status" => "error",
                "message" => __('Please add at least a chatbot item to can start')
            ]);
        }

        if(!empty($chatbot_item)){
            if($chatbot_item->run){
                db_update(TB_WHATSAPP_CHATBOT, [ 'run' => 0 ], [ 'instance_id' => $instance_id ]);
            }else{
                db_update(TB_WHATSAPP_CHATBOT, [ 'run' => 1 ], [ 'instance_id' => $instance_id ]);
            }
        }

        ms([
            "status" => "success",
            "message" => __('Success')
        ]);
    }

    public function delete(){
        $team_id = get_team("id");
        $ids = post('id');

        if( empty($ids) ){
            ms([
                "status" => "error",
                "message" => __('Please select an item to delete')
            ]);
        }

        if( is_array($ids) ){
            foreach ($ids as $id) {
                db_delete(TB_WHATSAPP_CHATBOT, ['ids' => $id, "team_id" => $team_id]);
            }
        }
        elseif( is_string($ids) )
        {
            db_delete(TB_WHATSAPP_CHATBOT, ['ids' => $ids, "team_id" => $team_id]);
        }

        ms([
            "status" => "success",
            "message" => __('Success')
        ]);
    }
}