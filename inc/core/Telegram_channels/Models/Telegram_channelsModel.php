<?php
namespace Core\Telegram_channels\Models;
use CodeIgniter\Model;

class Telegram_channelsModel extends Model
{
	public function __construct(){
        $this->config = include realpath( __DIR__."/../Config.php" );
    }
    
	public function block_accounts($path = ""){
        $team_id = get_team("id");
        $accounts = db_fetch("*", TB_ACCOUNTS, "social_network = 'telegram' AND category = 'channel' AND team_id = '{$team_id}'");
        return [
        	"button" => view( 'Core\Telegram_channels\Views\button', [ 'config' => $this->config ] ),
        	"content" => view( 'Core\Telegram_channels\Views\content', [ 'config' => $this->config, 'accounts' => $accounts ] )
        ];
    }
}
