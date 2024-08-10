<?php
namespace Core\Ai_prompt_templates\Models;
use CodeIgniter\Model;

class Ai_prompt_templatesModel extends Model
{
    public function get_list( $return_data = true, $pid = 0 )
    {
        $current_page = (int)(post("current_page") - 1);
        $per_page = post("per_page");
        $total_items = post("total_items");
        $keyword = post("keyword");

        $db = \Config\Database::connect();
        $builder = $db->table(TB_AI_PROMPT_TEMPLATES." as a");
        $builder->join(TB_AI_PROMPT_CATEGORIES." as b", "a.pid = b.id", "LEFT");
        $builder->select("a.*, b.ids as category_ids,b.icon,b.name,b.color");
        if($pid != 0){
            $builder->where("a.pid", $pid);
        }

        if( $keyword ){
            $array = [
                'a.content' => $keyword, 
                'b.name' => $keyword, 
                'b.desc' => $keyword
            ];
            $builder->orLike($array);
        }
        
        if( !$return_data )
        {
            $result =  $builder->countAllResults();
        }
        else
        {
            $builder->limit($per_page, $per_page*$current_page);
            $query = $builder->get();
            $result = $query->getResult();
            $query->freeResult();
        }
        
        return $result;
    }
}
