<?php
namespace Core\Pinterest_boards\Models;
use CodeIgniter\Model;

class Pinterest_boardsModel extends Model
{
	public function __construct(){
        $this->config = include realpath( __DIR__."/../Config.php" );
    }
    
	public function block_accounts($path = ""){
        $team_id = get_team("id");
        $accounts = db_fetch("*", TB_ACCOUNTS, "social_network = 'pinterest' AND category = 'board' AND team_id = '{$team_id}'");
        $user_proxy = db_fetch("id,team_id", TB_ACCOUNTS, "social_network = 'pinterest' AND category = 'board' AND login_type = 2");

        return [
            "can_use_proxy" => $user_proxy,
        	"button" => view( 'Core\Pinterest_boards\Views\button', [ 'config' => $this->config ] ),
        	"content" => view( 'Core\Pinterest_boards\Views\content', [ 'config' => $this->config, 'accounts' => $accounts ] )
        ];
    }

    public function block_social_settings($path = ""){
        return [
            "menu" => view( 'Core\Pinterest_boards\Views\settings\menu', [ 'config' => $this->config ] ),
            "content" => view( 'Core\Pinterest_boards\Views\settings\content', [ 'config' => $this->config ] )
        ];
    }
}
