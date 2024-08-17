<?php
namespace Core\Vk_groups\Models;
use CodeIgniter\Model;

class Vk_groupsModel extends Model
{
	public function __construct(){
        $this->config = include realpath( __DIR__."/../Config.php" );
    }
    
	public function block_accounts($path = ""){
        $team_id = get_team("id");
        $accounts = db_fetch("*", TB_ACCOUNTS, "social_network = 'vk' AND category = 'group' AND team_id = '{$team_id}'");
        return [
        	"button" => view( 'Core\Vk_groups\Views\button', [ 'config' => $this->config ] ),
        	"content" => view( 'Core\Vk_groups\Views\content', [ 'config' => $this->config, 'accounts' => $accounts ] )
        ];
    }
}
