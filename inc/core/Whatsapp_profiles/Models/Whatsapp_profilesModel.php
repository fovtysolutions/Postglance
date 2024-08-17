<?php
namespace Core\Whatsapp_profiles\Models;
use CodeIgniter\Model;

class Whatsapp_profilesModel extends Model
{
	public function __construct(){
        $this->config = include realpath( __DIR__."/../Config.php" );
    }
    
	public function block_accounts($path = ""){
        $team_id = get_team("id");
        $accounts = db_fetch("*", TB_ACCOUNTS, "social_network = 'whatsapp' AND category = 'profile' AND team_id = '{$team_id}'");
        return [
        	"button" => view( 'Core\Whatsapp_profiles\Views\button', [ 'config' => $this->config ] ),
        	"content" => view( 'Core\Whatsapp_profiles\Views\content', [ 'config' => $this->config, 'accounts' => $accounts ] )
        ];
    }

    public function block_social_settings($path = ""){
        return [
            "menu" => view( 'Core\Whatsapp_profiles\Views\settings\menu', [ 'config' => $this->config ] ),
            "content" => view( 'Core\Whatsapp_profiles\Views\settings\content', [ 'config' => $this->config ] )
        ];
    }
}
