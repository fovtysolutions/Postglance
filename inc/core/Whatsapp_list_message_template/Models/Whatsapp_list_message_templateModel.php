<?php
namespace Core\Whatsapp_list_message_template\Models;
use CodeIgniter\Model;

class Whatsapp_list_message_templateModel extends Model
{
	public function __construct(){
        $this->config = parse_config( include realpath( __DIR__."/../Config.php" ) );
    }

    public function block_plans(){
        return [
            "tab" => 15,
            "position" => 300,
            "label" => __("Whatsapp tool"),
            "items" => [
                [
                    "id" => $this->config['id'],
                    "name" => __("Send list messages"),
                ],
            ]
        ];
    }

    public function block_whatsapp(){
        $data = [
            "config" => $this->config
        ];

        return array(
            "position" => 7100,
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
        $builder = $db->table(TB_WHATSAPP_TEMPLATE);
        $builder->select('*');
        $builder->where("( type = 1 AND team_id = '{$team_id}' )");

        if( $keyword ){
            $builder->where("( name LIKE '%{$keyword}%' )") ;
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
        }
        
        return $result;
    }
}
