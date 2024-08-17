<?php
namespace Core\Whatsapp_bulk\Models;
use CodeIgniter\Model;

class Whatsapp_bulkModel extends Model
{
	public function __construct(){
        $this->config = parse_config( include realpath( __DIR__."/../Config.php" ) );
    }

    public function block_plans(){
        return [
            "tab" => 15,
            "position" => 100,
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
        $data = [
            "config" => $this->config
        ];

        return array(
            "position" => 4000,
            "config" => $this->config
        );
    }

    public function get_list( $return_data = true )
    {
        $team_id = get_team("id");
        $current_page = (int)(post("current_page") - 1);
        $per_page = post("per_page");
        $total_items = post("total_items");
        $keyword = post("keyword");

        $db = \Config\Database::connect();
        $builder = $db->table(TB_WHATSAPP_SCHEDULES);
        $builder->select('*');
        $builder->where("( team_id = '{$team_id}' )");

        if( $keyword ){
            $builder->where("( name LIKE '%{$keyword}%' OR caption LIKE '%{$keyword}%' )") ;
        }
        
        if( !$return_data )
        {
            $result =  $builder->countAllResults();
        }
        else
        {
            $builder->limit($per_page, $per_page*$current_page);
            $builder->orderBy("created", "DESC");
            $query = $builder->get();
            $result = $query->getResult();
            $query->freeResult();

            if(!empty($result)){
                foreach ($result as $key => $value) {
                    $count_phone = db_get("count(id) as count", TB_WHATSAPP_PHONE_NUMBERS, ["pid" => $value->contact_id])->count;
                    $result[$key]->total_phone_number = $count_phone;
                }
            }
        }
        
        return $result;
    }

    public function get_accounts($list = []){
        $team_id = get_team("id");
        $db = \Config\Database::connect();
        $builder = $db->table(TB_ACCOUNTS);
        $builder->select("*");
        $builder->where('team_id', $team_id);
        $builder->whereIn("ids", $list);
        $builder->where('status', 1);
        $query = $builder->get();
        $result = $query->getResult();
        $query->freeResult();

        $result_array = [];
        if(!empty($result)){
            foreach ($result as $key => $value) {
                $result_array[] = $value->id;
            }
        }

        if(!empty($result_array)){
            return json_encode($result_array);
        }else{
            return false;
        }
        
    }

    public function get_report($ids = ""){
        $team_id = get_team("id");
        $db = \Config\Database::connect();
        $builder = $db->table(TB_WHATSAPP_SCHEDULES." as a");
        $builder->select("a.*, c.name as contact_name");
        $builder->join(TB_WHATSAPP_CONTACTS." as c", "a.contact_id = c.id");
        $builder->where("a.ids",$ids);
        $builder->where("a.team_id", $team_id);
        $query = $builder->get();
        $result = $query->getRow();
        $query->freeResult();
        return $result;
    }

    public function get_report_by_day(){
        $daterange = post("daterange");
        if( $daterange != "" ){
            $daterange = explode(",", $daterange);
        }else{
            $daterange = [];
        }

        if(count($daterange) != 2){
            return false;
        }

        $date_since = timestamp_sql( $daterange[0]." 00:00:00" );
        $date_until = timestamp_sql( $daterange[1]." 23:59:59" );

        $team_id = get_team("id");
        $from = datetime_sql(post("from_day")." 00:00:00");
        $to = datetime_sql(post("to_day")." 23:59:59");
        $db = \Config\Database::connect();
        $builder = $db->table(TB_WHATSAPP_SCHEDULES." as a");
        $builder->select("a.*, c.name as contact_name");
        $builder->join(TB_WHATSAPP_CONTACTS." as c", "a.contact_id = c.id");
        $builder->where("a.team_id", $team_id);
        $builder->where("a.created BETWEEN '$date_since' AND '$date_until'");
        $query = $builder->get();
        $result = $query->getResult();
        return $result;
    }
}
