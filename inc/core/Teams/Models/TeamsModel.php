<?php
namespace Core\Teams\Models;
use CodeIgniter\Model;

class TeamsModel extends Model
{
	public function __construct(){
        $this->config = parse_config( include realpath( __DIR__."/../Config.php" ) );
    }

    public function block_plans(){
        return [
            "tab" => 30,
            "position" => 700,
            "label" => __("Advanced features"),
            "items" => [
                [
                    "id" => $this->config['id'],
                    "name" => "Team manager",
                ]
            ]
        ];
    }

    public function permissions(){
        $configs = get_blocks("block_permissions", true, true);

        if( ! empty($configs) ){
            $menus = [];
            foreach ($configs as $config) {
                if( isset( $config['menu'] ) && (!isset( $config['role'] ) || $config['role'] == 0 ) ){
                    $config['menu']['id'] =  isset($config['id'])?$config['id']:false;
                    $config['menu']['icon'] = isset($config['icon'])?$config['icon']:false;
                    $config['menu']['color'] = isset($config['color'])?$config['color']:false;
                    $config['menu']['data'] = isset($config['data'])?$config['data']:false;

                    
                    $menus[] = $config['menu'];
                }
            }

            if( count($menus) > 2 ){
                usort($menus, function($a, $b) {
                    return $a['position'] <=> $b['position'];
                });
                $menus = array_reverse($menus);
            }

            if( count($menus) > 2 ){
                usort($menus, function($a, $b) {
                    return $a['tab'] <=> $b['tab'];
                });
            }

            $permissions = [];
            foreach ($menus as $row) {
                $tab = $row['id'];
                $permissions[$tab][] = $row;
            }

        }

        return $permissions;
    }

    public function block_topbar($path = ""){
		$uid = get_user("id");
		$db = \Config\Database::connect();
		$builder = $db->table(TB_TEAM." as a");
		$builder->select("a.*, c.email, c.fullname");
		$builder->join(TB_TEAM_MEMBER." as b", "a.id = b.team_id");
		$builder->join(TB_USERS." as c", "a.owner = c.id");
		$builder->where("b.uid", $uid);
		$query = $builder->get();
        $result = $query->getResult();
        $query->freeResult();

        return array(
            "position" => 8000,
            "topbar" => view( 'Core\Teams\Views\topbar', [ 'config' => $this->config, "result" => $result ] )
        );
    }

    public function get_team_member($ids){
    	$team_id = get_team("id");

    	$db = \Config\Database::connect();
        $builder = $db->table(TB_TEAM_MEMBER." as a");
        $builder->select("a.*, b.email, b.fullname");
        $builder->join(TB_USERS." as b", "a.uid = b.id", "LEFT");
        $builder->where("a.team_id", $team_id);
        $builder->where("a.ids", $ids);
        $builder->orderBy("a.id", "ASC");
        $query = $builder->get();
        $result = $query->getRow();
        $query->freeResult();

        return $result;
	}

    public function get_team_members(){
        $team_id = get_team("id");

        $db = \Config\Database::connect();
        $builder = $db->table(TB_TEAM_MEMBER." as a");
        $builder->select("a.*, b.email, b.fullname");
        $builder->join(TB_USERS." as b", "a.uid = b.id");
        $builder->where("a.team_id", $team_id);
        $builder->orderBy("a.id", "ASC");
        $query = $builder->get();
        $result = $query->getResult();
        $query->freeResult();

        return $result;
    }
}
