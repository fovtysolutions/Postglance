<?php
namespace Core\Pinterest_boards\Controllers;
use \seregazhuk\PinterestBot\Factories\PinterestBot;

class Pinterest_boards extends \CodeIgniter\Controller
{
    public function __construct(){
        $reflect = new \ReflectionClass(get_called_class());
        $this->module = strtolower( $reflect->getShortName() );
        $this->config = include realpath( __DIR__."/../Config.php" );
        include get_module_dir( __DIR__ , 'Libraries/vendor/autoload.php');
        include get_module_dir( __DIR__ , 'Libraries/pinterest_api.php');
        $this->app_id = get_option('pinterest_app_id', '');
        $this->app_secret = get_option('pinterest_app_secret', '');
        $this->callback_url = get_module_url();

        if( get_option("pinterest_official", 1) && ($this->app_id == "" || $this->app_secret == "") ){
            redirect_to( base_url("social_network_settings/index/".$this->config['parent']['id']) ); 
        }

        $this->pinterest = new \Pinterest_API($this->app_id, $this->app_secret, $this->callback_url); 
        $this->bot = PinterestBot::create();
        $this->bot->getHttpClient()->setCookiesPath(WRITEPATH."pinterest/");

        if( !is_dir(WRITEPATH."pinterest/") ){
            create_folder( WRITEPATH."pinterest/" );
        }
    }
    
    public function index($page = "") {
        try {

            switch ($page) {
                case 'unofficial':
                    $proxy_item = asign_proxy("pinterest", "board", 2);
                    $username = get_session("pinterest_username");
                    $password = get_session("pinterest_password");

                    if($proxy_item){
                        $this->proxy( $proxy_item->proxy );
                    }
                    
                    $this->bot->auth->login($username, $password);
                    if ($this->bot->auth->isLoggedIn()) {
                        $response = $this->bot->user->profile();
                        if(!empty($response)){
                            $boards = $this->bot->boards->forUser($response['username']);
                            if(empty($boards)){
                                $profiles = [
                                    "status" => "error",
                                    "config" => $this->config,
                                    "message" => __("No boards were found in your account")
                                ];
                            }else{
                                $result = [];

                                foreach ($boards as $board) {
                                    $result[] = (object)[
                                        'id' => $board['id'],
                                        'name' => $board['name'],
                                        'avatar' => get_avatar( $board['name'] ),
                                        'desc' => $board['description']
                                    ];                 
                                }

                                $profiles = [
                                    "status" => "success",
                                    "config" => $this->config,
                                    "result" => $result
                                ];
                            }
                        }else{
                            $profiles = [
                                "status" => "error",
                                "config" => $this->config,
                                "message" => __("Login required")
                            ];
                        }
                    }else{
                        $profiles = [
                            "status" => "error",
                            "config" => $this->config,
                            "message" => $this->bot->getLastError()
                        ];
                    }

                    break;
                
                default:
                    if (get_option("pinterest_environment", 0)) {
                        if(!get_session("Pinterest_AccessToken")){
                            if(!get("code")){
                                redirect_to( get_module_url("oauth_official") );
                            }

                            $accessToken = $this->pinterest->get_access_token( get("code") );
                            set_session(["Pinterest_AccessToken" => json_encode($accessToken)]);
                        }else{
                            $accessToken = get_session("Pinterest_AccessToken");
                            $accessToken = json_decode($accessToken);
                        }
                    }else{
                        if(!get_session("Pinterest_AccessToken")){
                            if(!get("code")){
                                redirect_to( get_module_url("oauth_official") );
                            }

                            $accessToken = $this->pinterest->get_access_token( get("code") );
                            $accessToken_sandbox = get_session("Pinterest_AccessToken_Sandbox");
                            if( $accessToken_sandbox ){
                                $accessToken_sandbox = json_decode($accessToken_sandbox);
                                $accessToken_sandbox->access_token = $accessToken->access_token;
                                set_session(["Pinterest_AccessToken" => json_encode($accessToken_sandbox)]);
                            }else{
                                set_session(["Pinterest_AccessToken_Sandbox" => json_encode($accessToken)]);
                                $this->oauth_official();
                            }
                        }else{
                            $accessToken = get_session("Pinterest_AccessToken");
                            $accessToken = json_decode($accessToken);
                        }
                    }

                    $this->pinterest->set_access_token($accessToken->access_token);
                    $response = $this->pinterest->get_boards();

                    if(!empty($response) && isset($response->items) && !empty($response->items)){
                        $result = [];
                        foreach ($response->items as $value) {
                            $result[] = (object)[
                                'id' => $value->id,
                                'name' => $value->name,
                                'avatar' => get_avatar( $value->name ),
                                'desc' => $value->privacy
                            ];
                        }

                        $profiles = [
                            "status" => "success",
                            "config" => $this->config,
                            "result" => $result
                        ];
                    }else{
                        $profiles = [
                            "status" => "error",
                            "config" => $this->config,
                            "message" => __('No profile to add')
                        ];
                    }

            }

        } catch (\Exception $e) {
            $profiles = [
                "status" => "error",
                "config" => $this->config,
                "message" => $e->getMessage()
            ];
        }

        $data = [
            "title" => $this->config['name'],
            "desc" => $this->config['desc'],
            "content" => view('Core\Pinterest_boards\Views\add', $profiles)
        ];

        return view('Core\Pinterest_boards\Views\index', $data);
    }

    public function oauth(){
        $oauth_link = get_module_url("oauth_official");
        if( !get_option("pinterest_unofficial", 1) ){
            redirect_to($oauth_link);
        }

        $data = [
            "title" => $this->config['name'],
            "desc" => $this->config['desc'],
            "content" => view('Core\Pinterest_boards\Views\oauth', [ "config" => $this->config, "oauth_link" => $oauth_link ])
        ];

        return view('Core\Pinterest_boards\Views\index', $data);
    }

    public function oauth_official(){
        remove_session(["Pinterest_AccessToken"]);
        $oauth_link = $this->pinterest->login_url();
        redirect_to($oauth_link);        
    }

    public function oauth_unofficial(){
        try {
            $proxy_item = asign_proxy("pinterest", "board", 2);
            $username = post("username");
            $password = post("password");

            if($proxy_item){
                $this->proxy( $proxy_item->proxy );
            }

            $this->bot->auth->login($username, $password);
            if ($this->bot->auth->isLoggedIn()) {
                $response = $this->bot->user->profile();
                if(!empty($response)){

                    $boards = $this->bot->boards->forUser($response['username']);

                    if(empty($boards)){
                        ms(array(
                            "status" => "error",
                            "message" => __("No boards were found in your account")
                        ));
                    }

                    set_session(["pinterest_username" => $username]);
                    set_session(["pinterest_password" => $password]);

                    ms([
                        "status" => "success",
                        "message" => __("Success")
                    ]);
                }else{
                    ms([
                        "status" => "error",
                        "message" => __("Login required")
                    ]);
                }
            }else{
                if( $this->bot->getLastError() ){
                    $message = __( $this->bot->getLastError() );
                }else{

                    if($proxy_item){
                        $message = __( "Unable to add account. Please try using a different proxy." );
                    }else{
                        $message = __( "Unable to add account. Please try again using a proxy." );
                    }
                }

                ms([
                    "status" => "error",
                    "message" => $message
                ]);
            }
        } catch (\Exception $e) {
            ms([
                "status" => "error",
                "message" => __( $e->getMessage() )
            ]);
        }
    }

    public function save()
    {
        try {
            $ids = post('id');
            $team_id = get_team("id");

            validate('empty', __('Please select a profile to add'), $ids);

            $accessToken = get_session("Pinterest_AccessToken");
            $accessToken = json_decode($accessToken);
            $this->pinterest->set_access_token($accessToken->access_token);

            $response = $this->pinterest->get_boards();

            if(!is_string($response)){

                if(!empty($response) && isset($response->items) && !empty($response->items)){
                    foreach ($response->items as $value) {

                        if( in_array($value->id, $ids) ){
                            
                            $item = db_get('*', TB_ACCOUNTS, "social_network = 'pinterest' AND login_type = '1' AND team_id = '{$team_id}' AND pid = '".$value->id."'");

                            if(!$item){
                                //Check limit number 
                                check_number_account("pinterest", "board");
                                $avatar = get_avatar( $value->name );
                                $avatar = save_img( $avatar, WRITEPATH.'avatar/' );
                                $data = [
                                    'ids' => ids(),
                                    'module' => $this->module,
                                    'social_network' => 'pinterest',
                                    'category' => 'board',
                                    'login_type' => 1,
                                    'can_post' => 1,
                                    'team_id' => $team_id,
                                    'pid' => $value->id,
                                    'name' => $value->name,
                                    'username' => $value->name,
                                    'token' => json_encode($accessToken),
                                    'avatar' => $avatar,
                                    'url' => "https://www.pinterest.com/".$value->owner->username,
                                    'data' => NULL,
                                    'status' => 1,
                                    'changed' => time(),
                                    'created' => time()
                                ];

                                db_insert(TB_ACCOUNTS, $data);
                                remove_session(["Pinterest_AccessToken_Sandbox", "Pinterest_AccessToken"]);
                            }else{
                                unlink( get_file_path($item->avatar) );
                                $avatar = get_avatar( $value->name );
                                $avatar = save_img( $avatar, WRITEPATH.'avatar/' );
                                $data = [
                                    'can_post' => 1,
                                    'pid' => $value->id,
                                    'name' => $value->name,
                                    'username' => $value->name,
                                    'token' => json_encode($accessToken),
                                    'avatar' => $avatar,
                                    'url' => "https://www.pinterest.com/".$value->owner->username,
                                    'status' => 1,
                                    'changed' => time(),
                                ];

                                db_update(TB_ACCOUNTS, $data, ['id' => $item->id]);
                                remove_session(["Pinterest_AccessToken_Sandbox", "Pinterest_AccessToken"]);
                            }
                        }
                    }
                }else{
                    ms([
                        "status" => "error",
                        "message" => __('No profile to add')
                    ]);
                }

                ms([
                    "status" => "success",
                    "message" => __("Success")
                ]);
            }else{
                ms([
                    "status" => "error",
                    "message" => $response
                ]);
            }

            
        } catch (\Exception $e) {
            ms([
                "status" => "error",
                "message" => $e->getMessage()
            ]);
        }
    }

    public function save_unofficial(){

        try {
            $proxy_item = asign_proxy("pinterest", "board", 2);
            $ids = post('id');
            $team_id = get_team("id");
            $username = get_session("pinterest_username");
            $password = get_session("pinterest_password");
            $proxy_id = $proxy_item?$proxy_item->id:"";

            validate('empty', __('Please select a profile to add'), $ids);

            if($proxy_item){
                $this->proxy( $proxy_item->proxy );
            }

            $this->bot->auth->login($username, $password);
            if ($this->bot->auth->isLoggedIn()) {
                $response = $this->bot->user->profile();
                if(!empty($response)){

                    $boards = $this->bot->boards->forUser($response['username']);

                    $accessToken = serialize([
                        "username" => $response['username'],
                        "password" => encrypt_encode($password)
                    ]);

                    if(empty($boards)){
                        ms([
                            "status" => "error",
                            "message" => __("No boards were found in your account")
                        ]);
                    }

                    foreach ($boards as $board) {

                        if( in_array($board['id'], $ids) ){

                            
                            $item = db_get('*', TB_ACCOUNTS, "social_network = 'pinterest' AND login_type = '2' AND team_id = '{$team_id}' AND pid = '".$board['id']."'");

                            if(!$item){
                                //Check limit number 
                                check_number_account("pinterest", "board");
                                $avatar = get_avatar( $board['name'] );
                                $avatar = save_img( $avatar, WRITEPATH.'avatar/' );
                                $data = [
                                    'ids' => ids(),
                                    'module' => $this->module,
                                    'social_network' => 'pinterest',
                                    'category' => 'board',
                                    'login_type' => 2,
                                    'can_post' => 1,
                                    'team_id' => $team_id,
                                    'pid' => $board['id'],
                                    'name' => $board['name'],
                                    'username' => $board['name'],
                                    'token' => $accessToken,
                                    'avatar' => $avatar,
                                    'url' => "https://www.pinterest.com".$board['url'],
                                    'proxy' => $proxy_id,
                                    'data' => NULL,
                                    'status' => 1,
                                    'changed' => time(),
                                    'created' => time()
                                ];

                                db_insert(TB_ACCOUNTS, $data);
                            }else{
                                unlink( get_file_path($item->avatar) );
                                $avatar = get_avatar( $board['name'] );
                                $avatar = save_img( $avatar, WRITEPATH.'avatar/' );
                                $data = [
                                    'can_post' => 1,
                                    'pid' => $board['id'],
                                    'name' => $board['name'],
                                    'username' => $board['name'],
                                    'token' => $accessToken,
                                    'avatar' => $avatar,
                                    'url' => "https://www.pinterest.com".$board['url'],
                                    'proxy' => $proxy_id,
                                    'status' => 1,
                                    'changed' => time(),
                                ];

                                db_update(TB_ACCOUNTS, $data, ['id' => $item->id]);
                            }
                        }
                    }

                    remove_session(["pinterest_username"]);
                    remove_session(["pinterest_password"]);

                    ms([
                        "status" => "success",
                        "message" => __("Success")
                    ]);
                }else{
                    ms([
                        "status" => "error",
                        "message" => __("Login required")
                    ]);
                }
            }else{
                ms([
                    "status" => "error",
                    "message" => $this->bot->getLastError()
                ]);
            }

        } catch (\Exception $e) {
            ms([
                "status" => "error",
                "message" => $e->getMessage()
            ]);
        }

    }

    public function proxy($proxy){
        if($proxy != "" && $proxy != 0){
            $proxy = str_replace("https://", "", $proxy);
            $proxy = str_replace("http://", "", $proxy);
            $ip = "";
            $port = "";
            $auth = "";

            if(strripos($proxy, "@") !== false){

                $proxy_arr = explode("@", $proxy);
                $auth = $proxy_arr[0];
                $proxy_none = explode(":", $proxy_arr[1]);
                $ip = $proxy_none[0];
                $port = $proxy_none[1];
                $this->bot->getHttpClient()->useProxy($ip, $port, $auth);
            }else{
                $proxy_none = explode(":", $proxy);
                $ip = $proxy_none[0];
                $port = $proxy_none[1];
                $this->bot->getHttpClient()->useProxy($ip, $port);

            }
        }else{
            $this->bot->getHttpClient()->dontUseProxy();
        }
    }
}