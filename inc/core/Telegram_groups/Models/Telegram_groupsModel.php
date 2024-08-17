<?php
namespace Core\Telegram_groups\Models;
use CodeIgniter\Model;

class Telegram_groupsModel extends Model
{
	public function __construct(){
        $this->config = include realpath( __DIR__."/../Config.php" );
    }
    
	public function block_accounts($path = ""){
        $team_id = get_team("id");
        $accounts = db_fetch("*", TB_ACCOUNTS, "social_network = 'telegram' AND category = 'group' AND team_id = '{$team_id}'");
        return [
        	"button" => view( 'Core\Telegram_groups\Views\button', [ 'config' => $this->config ] ),
        	"content" => view( 'Core\Telegram_groups\Views\content', [ 'config' => $this->config, 'accounts' => $accounts ] )
        ];
    }
}
