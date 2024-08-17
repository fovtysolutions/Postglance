<?php
namespace Core\Facebook_groups\Controllers;

class Facebook_groups extends \CodeIgniter\Controller
{
    public function __construct(){
        $reflect = new \ReflectionClass(get_called_class());
        $this->module = strtolower( $reflect->getShortName() );
        $this->config = include realpath( __DIR__."/../Config.php" );
        include get_module_dir( __DIR__ , '../Facebook_profiles/Libraries/FacebookCookieApi.php');
        $app_id = get_option('facebook_client_id', '');
        $app_secret = get_option('facebook_client_secret', '');
        $app_version = get_option('facebook_app_version', 'v16.0');

        if($app_id == "" || $app_secret == "" || $app_version == ""){
            redirect_to( base_url("social_network_settings/index/".$this->config['parent']['id']) ); 
        }

        $fb = new \JanuSoftware\Facebook\Facebook([
            'app_id' => $app_id,
            'app_secret' => $app_secret,
            'default_graph_version' => $app_version,
        ]);

        $this->fb = $fb;
        $this->proxy_item = FALSE;
        $this->proxy = NULL;
    }
    
    public function index($page = "") {
        switch ($page) {
            case 'cookie':
                $fb_user_id = get_session("fb_user_id");
                $fb_session = get_session("fb_session");

                if(!$fb_session || !$fb_user_id){
                    redirect_to( get_module_url("oauth_cookies") );
                }

                $this->proxy($fb_user_id);
                $fb_auth = new \FacebookCookieApi($fb_user_id, $fb_session, $this->proxy);
                $response = $fb_auth->getGroups();

                if(!empty($response)){

                    if(isset($response)){
                        $result = [];
                        foreach ($response as $value) {
                            $result[] = (object)[
                                'id' => $value['id'],
                                'name' => $value['name'],
                                'avatar' => $value['cover'],
                                'desc' => $value['name']
                            ];
                        }

                        $profiles = [
                            "status" => "success",
                            "config" => $this->config,
                            "result" => $result,
                            "save_url" => get_module_url("save_cookie")
                        ];
                    }else{
                        $profiles = [
                            "status" => "error",
                            "config" => $this->config,
                            "message" => __('No profile to add'),
                            "save_url" => ""
                        ];
                    }
                }else{
                    $profiles = [
                        "status" => "error",
                        "config" => $this->config,
                        "message" => __('No profile to add'),
                        "save_url" => ""
                    ];
                }
                break;

            default:
                try {
                    if( !get_session("FB_AccessToken") ){

                        if(!get('code')){
                            redirect_to( get_module_url("oauth") );
                        }

                        $callback_url = get_module_url();
                        $helper = $this->fb->getRedirectLoginHelper();
                        if ( get("state") ) {
                            $helper->getPersistentDataHandler()->set('state', get("state"));
                        }
                        $accessToken = $helper->getAccessToken($callback_url);
                        $accessToken = $accessToken->getValue();
                        set_session( ['FB_AccessToken' => $accessToken] );
                        redirect_to( $callback_url );
                    }else{
                        $accessToken = get_session("FB_AccessToken"); 
                    }

                    $response = $this->fb->get('/me/groups?fields=id,icon,name,description,email,privacy,cover&admin_only=true&limit=10000', $accessToken)->getDecodedBody();
                    if(is_string($response)){
                        $response = $this->fb->get('/me/groups?fields=id,icon,name,description,email,privacy,cover&admin_only=true&limit=3', $accessToken)->getDecodedBody();
                    }

                    if(!is_string($response)){
                        if(!empty($response)){

                            if(isset($response['data']) && !empty($response['data'])){
                                $result = [];
                                foreach ($response['data'] as $value) {
                                    $result[] = (object)[
                                        'id' => $value['id'],
                                        'name' => $value['name'],
                                        'avatar' => $value['icon'],
                                        'desc' => $value['name']
                                    ];
                                }

                                $profiles = [
                                    "status" => "success",
                                    "config" => $this->config,
                                    "result" => $result,
                                    "save_url" => get_module_url("save")
                                ];
                            }else{
                                $profiles = [
                                    "status" => "error",
                                    "config" => $this->config,
                                    "message" => __('No profile to add'),
                                    "save_url" => ""
                                ];
                            }
                        }
                    }else{
                        $profiles = [
                            "status" => "error",
                            "config" => $this->config,
                            "message" => $response,
                            "save_url" => ""
                        ];
                    }
                } catch (\Exception $e) {
                    $profiles = [
                        "status" => "error",
                        "config" => $this->config,
                        "message" => $e->getMessage(),
                        "save_url" => ""
                    ];
                }
        }

        $data = [
            "title" => $this->config['name'],
            "desc" => $this->config['desc'],
            "content" => view('Core\Facebook_groups\Views\add', $profiles)
        ];

        return view('Core\Facebook_groups\Views\index', $data);
    }

    public function oauth(){
        $oauth_link = get_module_url("oauth_official");
        if( !get_option("facebook_group_cookie_status", 1) && get_option("facebook_group_official_status", 1) ){
            redirect_to($oauth_link);
        }

        if( !get_option("facebook_group_cookie_status", 1) && !get_option("facebook_group_official_status", 1) ){
            redirect_to( base_url("account_manager") );
        }

        $data = [
            "title" => $this->config['name'],
            "desc" => $this->config['desc'],
            "content" => view('Core\Facebook_groups\Views\oauth', [ "config" => $this->config, "oauth_link" => $oauth_link ])
        ];

        return view('Core\Facebook_groups\Views\index', $data);
    }

    public function oauth_official(){
        remove_session(['FB_AccessToken']);
        $helper = $this->fb->getRedirectLoginHelper();
        $permissions = [ get_option("facebook_group_permissions", "publish_to_groups") ];
        $login_url = $helper->getLoginUrl( get_module_url() , $permissions);
        redirect_to($login_url);
    }

    public function oauth_cookies(){
        $fb_user_id = post("fb_user_id");
        $fb_session = post("fb_session");

        validate('null', __('Facebook user id'), $fb_user_id);
        validate('null', __('Facebook session'), $fb_session);

        $this->proxy($fb_user_id);
        $fb_auth = new \FacebookCookieApi($fb_user_id, $fb_session, $this->proxy);
        $data = $fb_auth->authorizeFbUser();

        if($data['status'] == "error"){
            ms($data);
        }

        set_session([
            "fb_user_id" => $fb_user_id,
            "fb_session" => $fb_session
        ]);

        ms($data);
    }

    public function save()
    {
        try {
            $ids = post('id');
            $team_id = get_team("id");
            $accessToken = get_session('FB_AccessToken');

            validate('empty', __('Please select a profile to add'), $ids);

            $response = $this->fb->get('/me/groups?fields=id,icon,name,description,email,privacy,cover&admin_only=true&limit=10000', $accessToken)->getDecodedBody();
            if(is_string($response)){
                $response = $this->fb->get('/me/groups?fields=id,icon,name,description,email,privacy,cover&admin_only=true&limit=3', $accessToken)->getDecodedBody();
            }

            if(!is_string($response)){

                if(isset($response['data']) && !empty($response['data'])){
                    foreach ($response['data'] as $row) {

                        if(in_array($row['id'], $ids, true)){
                            $item = db_get('*', TB_ACCOUNTS, "social_network = 'facebook' AND team_id = '{$team_id}' AND pid = '".$row['id']."'");
                            if(!$item){
                                //Check limit number 
                                check_number_account("facebook", "group");
                                $avatar = save_img( $row['icon'], WRITEPATH.'avatar/' );
                                $data = [
                                    'ids' => ids(),
                                    'module' => $this->module,
                                    'social_network' => 'facebook',
                                    'category' => 'group',
                                    'login_type' => 1,
                                    'can_post' => 1,
                                    'team_id' => $team_id,
                                    'pid' => $row['id'],
                                    'name' => $row['name'],
                                    'username' => $row['name'],
                                    'token' => $accessToken,
                                    'avatar' => $avatar,
                                    'url' => 'https://fb.com/'.$row['id'],
                                    'data' => NULL,
                                    'status' => 1,
                                    'changed' => time(),
                                    'created' => time()
                                ];

                                db_insert(TB_ACCOUNTS, $data);
                            }else{
                                unlink( get_file_path($item->avatar) );
                                $avatar = save_img( $row['icon'], WRITEPATH.'avatar/' );

                                $data = [
                                    'can_post' => 1,
                                    'pid' => $row['id'],
                                    'name' => $row['name'],
                                    'username' => $row['name'],
                                    'token' => $accessToken,
                                    'avatar' => $avatar,
                                    'url' => 'https://fb.com/'.$row['id'],
                                    'status' => 1,
                                    'changed' => time(),
                                ];

                                db_update(TB_ACCOUNTS, $data, ['id' => $item->id]);
                            }
                        }
                    }

                    ms([
                        "status" => "success",
                        "message" => __("Success")
                    ]);
                }else{
                    ms([
                        "status" => "error",
                        "message" => __('No profile to add')
                    ]);
                }
       
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

    public function save_cookie()
    {
        try {
            $ids = post('id');
            $team_id = get_team("id");
            $fb_user_id = get_session("fb_user_id");
            $fb_session = get_session("fb_session");

            if(!$fb_session || !$fb_user_id){
                validate('empty', __('Cannot connect to your Facebook account'), $ids);
            }

            validate('empty', __('Please select a profile to add'), $ids);
            $this->proxy($fb_user_id);
            $fb_auth = new \FacebookCookieApi($fb_user_id, $fb_session, $this->proxy);
            $response = $fb_auth->getGroups();

            if(!is_string($response)){

                if(!empty($response)){
                    $user_info = $fb_auth->authorizeFbUser();
                    $accessToken = json_encode([ "fb_user_id" => $fb_user_id, "fb_session" => $fb_session ]);

                    foreach ($response as $row) {

                        if(in_array($row['id'], $ids, true)){
                            $item = db_get('*', TB_ACCOUNTS, "social_network = 'facebook' AND team_id = '{$team_id}' AND pid = '".$row['id']."'");
                            if(!$item){
                                //Check limit number 
                                check_number_account("facebook", "group");
                                $avatar = save_img( $row['cover'], WRITEPATH.'avatar/' );
                                $data = [
                                    'ids' => ids(),
                                    'module' => $this->module,
                                    'social_network' => 'facebook',
                                    'category' => 'group',
                                    'login_type' => 3,
                                    'can_post' => 1,
                                    'team_id' => $team_id,
                                    'pid' => $row['id'],
                                    'name' => $row['name'],
                                    'username' => $row['name'],
                                    'token' => $accessToken,
                                    'avatar' => $avatar,
                                    'url' => 'https://fb.com/'.$row['id'],
                                    'proxy' => $this->proxy_item?$this->proxy_item->id:"",
                                    'tmp' => $user_info['id'],
                                    'data' => NULL,
                                    'status' => 1,
                                    'changed' => time(),
                                    'created' => time()
                                ];

                                db_insert(TB_ACCOUNTS, $data);
                            }else{
                                @unlink( get_file_path($item->avatar) );
                                $avatar = save_img( $row['cover'], WRITEPATH.'avatar/' );
                                $data = [
                                    'can_post' => 1,
                                    'pid' => $row['id'],
                                    'name' => $row['name'],
                                    'username' => $row['name'],
                                    'token' => $accessToken,
                                    'avatar' => $avatar,
                                    'url' => 'https://fb.com/'.$row['id'],
                                    'proxy' => $this->proxy_item?$this->proxy_item->id:"",
                                    'tmp' => $user_info['id'],
                                    'status' => 1,
                                    'changed' => time(),
                                ];

                                db_update(TB_ACCOUNTS, $data, ['id' => $item->id]);
                            }
                        }
                    }

                    ms([
                        "status" => "success",
                        "message" => __("Success")
                    ]);
                }else{
                    ms([
                        "status" => "error",
                        "message" => __('No profile to add')
                    ]);
                }
       
            }else{
                ms([
                    "status" => "error",
                    "message" => $response
                ]);
            }
        } catch (Exception $e) {
            ms([
                "status" => "error",
                "message" => $e->getMessage()
            ]);
        }
    }

    public function proxy($fb_user_id){
        $account_item = db_get("proxy", TB_ACCOUNTS, ["tmp" => $fb_user_id]);
        if($account_item && $account_item->proxy != ""){
            $get_proxy = db_get("proxy", TB_PROXIES, ["id" => $account_item->proxy]);
            if($get_proxy){
                $proxy_item = $get_proxy;
            }else{
                $proxy_item = asign_proxy("facebook", "group", 3);
            }
        }else{
            $proxy_item = asign_proxy("facebook", "group", 3);
        }

        if($proxy_item){
            $this->proxy_item = $proxy_item;
            $this->proxy = $proxy_item->proxy;
        }
    }
}