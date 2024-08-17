<?php
namespace Core\Youtube_profiles\Models;
use CodeIgniter\Model;

class Youtube_profilesModel extends Model
{
	public function __construct(){
        $this->config = include realpath( __DIR__."/../Config.php" );
    }
    
	public function block_accounts($path = ""){
        $team_id = get_team("id");
        $accounts = db_fetch("*", TB_ACCOUNTS, "social_network = 'youtube' AND category = 'channel' AND team_id = '{$team_id}'");
        return [
        	"button" => view( 'Core\Youtube_profiles\Views\button', [ 'config' => $this->config ] ),
        	"content" => view( 'Core\Youtube_profiles\Views\content', [ 'config' => $this->config, 'accounts' => $accounts ] )
        ];
    }

    public function block_social_settings($path = ""){
        return [
            "menu" => view( 'Core\Youtube_profiles\Views\settings\menu', [ 'config' => $this->config ] ),
            "content" => view( 'Core\Youtube_profiles\Views\settings\content', [ 'config' => $this->config ] )
        ];
    }
}
