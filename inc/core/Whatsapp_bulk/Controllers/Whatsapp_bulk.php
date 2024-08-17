<?php
namespace Core\Whatsapp_bulk\Controllers;

class Whatsapp_bulk extends \CodeIgniter\Controller
{
    public function __construct(){
        $this->config = parse_config( include realpath( __DIR__."/../Config.php" ) );
        $this->model = new \Core\Whatsapp_bulk\Models\Whatsapp_bulkModel();
    }
    
    public function index( $page = false, $ids = false) {
        $data = [
            "title" => $this->config['name'],
            "desc" => $this->config['desc'],
        ];

        switch ( $page ) {
            case 'update':
                $team_id = get_team("id");
                $item = false;
                if( $ids ){
                    $item = db_get("*", TB_WHATSAPP_SCHEDULES, [ "ids" => $ids, "team_id" => $team_id ]);
                }

                $contacts = db_fetch("*", TB_WHATSAPP_CONTACTS, ["team_id" => $team_id, "status" => 1], "id", "DESC");

                $data['content'] = view('Core\Whatsapp_bulk\Views\update', ["result" => $item, "contacts" => $contacts, "config" => $this->config]);
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

                $data['content'] = view('Core\Whatsapp_bulk\Views\content', $data_content );
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
            "data" => view('Core\Whatsapp_bulk\Views\ajax_list', $data)
        ] );
    }

    public function report($ids = ""){
        $result = $this->model->get_report($ids);
        if( empty( $result )){
            return false;
        }
        $file=$result->name.".xls";
        $report = view('Core\Whatsapp_bulk\Views\report', [ 'result' => $result ]);
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$file");
        echo $report;
    }

    public function report_by_day(){
        $result = $this->model->get_report_by_day();
        $file="campaign_report.xls";
        $report = view('Core\Whatsapp_bulk\Views\report_by_day', [ 'result' => $result ]);
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$file");
        echo $report;
    }

    public function popup_report(){
        $team_id = get_team("id");
        $data = [
            'config'  => $this->config,
        ];
        return view('Core\Whatsapp_bulk\Views\popup_report', $data);
    }

    public function save($ids = false){
        $team_id = get_team("id");
        $type = (int)post("type");
        $name = post("name");
        $group = post("group");
        $medias = post("medias");
        $caption = post("caption"); 
        $advance_options = post("advance_options");
        $template = 0;
        $btn_msg = (int)post("btn_msg");
        $list_msg = (int)post("list_msg");
        $min_interval_per_post = (int)post("min_interval_per_post");
        $max_interval_per_post = (int)post("max_interval_per_post");
        $schedule_time = post("schedule_time");
        $accounts = post("accounts");
        $time_post = timestamp_sql(post("time_post"));
        $item = db_get("*", TB_WHATSAPP_SCHEDULES, ["ids" => $ids, "team_id" => $team_id]);

        if( !empty($schedule_time) ){
            foreach ($schedule_time as $key => $value) {
                if ((int)$value < 0 || (int)$value > 23) {
                    unset($schedule_time[$key]);
                }
            }
            $schedule_time = json_encode($schedule_time);
        }else{
            $schedule_time = "";
        }
        
        validate('null', __('Campaign name'), $name);
        validate("max_length", "Campaign name", $name, 100);
        validate('null', __('Contact group'), $group);

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

        validate("min_number", __("Min interval"), $min_interval_per_post, 1);
        validate("min_number", __("Max interval"), $max_interval_per_post, 1);

        if($min_interval_per_post > $max_interval_per_post){
            ms([
                "status" => "error",
                "message" => __('Max interval must be greater than or equal to min interval')
            ]);
        }

        if(empty($item)){
            validate('null', __('Time post'), $time_post);
        }

        $group = db_get("*", TB_WHATSAPP_CONTACTS, ["id" => $group, "team_id" => $team_id]);

        validate('empty', __('Please select at least a profile'), $accounts);
        validate('empty', __('Please select a contact group'), $group);

        $accounts = $this->model->get_accounts($accounts);

        if(!$accounts){
            ms([
                "status" => "error",
                "message" => __("You need to log in again to access your selected WhatsApp accounts.")
            ]);
        }

        if(!empty($medias) && permission("whatsapp_send_media")){
            foreach ($medias as $key => $value) {
                $medias[$key] = get_file_url($value);
            }

            $media = $medias[0];
        }else{
            $media = NULL;
        }

        if(!empty($advance_options) && isset($advance_options['shortlink'])){
            $shortlink_by = shortlink_by(['advance_options' => [ 'shortlink' => $advance_options['shortlink'] ]]);
            $caption = shortlink($caption, $shortlink_by);
        }

        if(!empty($item)){
            $data = [
                "team_id" => $team_id,
                "type" => $type,
                "template" => $template,
                "accounts" => $accounts,
                "contact_id" => $group->id,
                "time_post" => $time_post,
                "min_delay" => $min_interval_per_post,
                "max_delay" => $max_interval_per_post,
                "schedule_time" => $schedule_time,
                "timezone" => get_user("timezone"),
                "name" => $name,
                "caption" => $caption,
                "media" => $media,
                "run" => 0,
                "changed" => time()
            ];

            $result = db_update( TB_WHATSAPP_SCHEDULES, $data, ["id" => $item->id]);
        }else{
            $campaign_running = db_get("count(*) as count", TB_WHATSAPP_SCHEDULES, ["status" => 1, "team_id" => $team_id])->count;
            if($campaign_running >= (int)permission("whatsapp_bulk_max_run")){
                $status = 0;
            }else{
                $status = 1;
            }

            $data = [
                "ids" => ids(),
                "team_id" => $team_id,
                "type" => $type,
                "template" => $template,
                "accounts" => $accounts,
                "contact_id" => $group->id,
                "time_post" => $time_post,
                "min_delay" => $min_interval_per_post,
                "max_delay" => $max_interval_per_post,
                "schedule_time" => $schedule_time,
                "timezone" => get_user("timezone"),
                "name" => $name,
                "caption" => $caption,
                "media" => $media,
                "run" => 0,
                "status" => $status,
                "changed" => time(),
                "created" => time()
            ];

            $result = db_insert( TB_WHATSAPP_SCHEDULES, $data);
        }

        ms([
            "status" => "success",
            "message" => __("Success")
        ]);
    }

    public function status( $ids = false ){
        $team_id = get_team('id');
        $item = db_get("*", TB_WHATSAPP_SCHEDULES, ["ids" => $ids, "team_id" => $team_id]);

        if(!$item){
            ms([
                "status" => "error",
                "message" => __('The bulk campaign was not found')
            ]);
        }

        if(!empty($item)){

            if($item->status == 2){
                ms([
                    "status" => "error",
                    "message" => __('The campaign has been completed.')
                ]);
            }

            if($item->status == 1){
                db_update(TB_WHATSAPP_SCHEDULES, [ 'status' => 0, 'run' => 0 ], [ 'ids' => $ids ]);
            }else{
                $stats = db_get("wa_total_sent_by_month", TB_WHATSAPP_STATS, ["team_id" => $team_id]);
                $permissions = (int)permission("whatsapp_message_per_month");
                if ($stats && $stats->wa_total_sent_by_month >= $permissions){
                    ms([
                        "status" => "error",
                        "message" => __('You have exceeded the maximum number of messages you can send per month.')
                    ]);
                }

                $campaign_running = db_get("count(*) as count", TB_WHATSAPP_SCHEDULES, ["status" => 1, "team_id" => $team_id])->count;
                if($campaign_running >= (int)permission("whatsapp_bulk_max_run")){
                    ms([
                        "status" => "error",
                        "message" => sprintf( __('You can only run a maximum of %s campaigns at the same time.'), (int)permission("whatsapp_bulk_max_run"))
                    ]);
                }

                db_update(TB_WHATSAPP_SCHEDULES, [ 'status' => 1, 'run' => 0 ], [ 'ids' => $ids ]);
            }
        }

        ms([
            "status" => "success",
            "message" => __('Success')
        ]);
    }

    public function delete($ids = false){
        $team_id = get_team("id");
        if( !$ids ){
            ms([
                "status" => "error",
                "message" => __('Please select an item to delete')
            ]);
        }

        db_delete(TB_WHATSAPP_SCHEDULES, ['ids' => $ids, "team_id" => $team_id]);

        ms([
            "status" => "success",
            "message" => __('Success')
        ]);
    }
}