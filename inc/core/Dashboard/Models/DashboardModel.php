<?php
namespace Core\Dashboard\Models;
use CodeIgniter\Model;

class DashboardModel extends Model
{
	public function __construct(){
        $this->config = parse_config( include realpath( __DIR__."/../Config.php" ) );
    }
    
    public function block_dashboard($path = ""){
        $configs = get_blocks("block_quicks", false, true);
        $user_plan = (int)get_user("plan");
        $plan = db_get( "*" , TB_PLANS, ["id" => $user_plan] );

        return [
            "position" => 1000,
            "html" =>  view( 'Core\Profile\Views\quick', [ 'config' => $this->config, "result" => $configs, "plan" => $plan] )
        ];
    }
}
