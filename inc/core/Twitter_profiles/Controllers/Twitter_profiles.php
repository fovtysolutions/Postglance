<?php
namespace Core\Twitter_profiles\Controllers;
use Abraham\TwitterOAuth\TwitterOAuth;
use Coderjerk\BirdElephant\BirdElephant;

class Twitter_profiles extends \CodeIgniter\Controller
{
    public $proxy;

    public function __construct(){
        $reflect = new \ReflectionClass(get_called_class());
        $this->module = strtolower( $reflect->getShortName() );
        $this->config = include realpath( __DIR__."/../Config.php" );
        include get_module_dir( __DIR__ , 'Libraries/TwitterCookieApi.php');
        $this->client_id = get_team_data("twitter_client_id", "");
        $this->client_secret = get_team_data("twitter_client_secret", "");
        $this->consumer_key = get_team_data("twitter_consumer_key", "");
        $this->consumer_secret = get_team_data("twitter_consumer_secret", "");
        $this->bearer_token = get_team_data("twitter_bearer_token", "");

        if(!get_team_data("twitter_status", 0) || 
            $this->client_id == "" || 
            $this->client_secret == "" ||
            $this->consumer_key == "" ||
            $this->consumer_secret == "" ||
            $this->bearer_token == ""
        ){
            $this->client_id = get_option('twitter_client_id', '');
            $this->client_secret = get_option('twitter_client_secret', '');
            $this->consumer_key = get_option('twitter_consumer_key', '');
            $this->consumer_secret = get_option('twitter_consumer_secret', '');
            $this->bearer_token = get_option('twitter_bearer_token', '');
        }

        $this->callback_url = get_module_url();
        if(
            $this->client_id == "" || 
            $this->client_secret == "" ||
            $this->consumer_key == "" ||
            $this->consumer_secret == "" ||
            $this->bearer_token == ""
        ){
            redirect_to( base_url("social_network_settings/index/".$this->config['parent']['id']) ); 
        }

        $this->twitter = new \Smolblog\OAuth2\Client\Provider\Twitter([
            'clientId'          => $this->client_id,
            'clientSecret'      => $this->client_secret,
            'redirectUri'       => $this->callback_url,
        ]);

        $this->twitter_options = [
            'scope' => [
                'tweet.read',
                'tweet.write',
                'tweet.moderate.write',
                'users.read',
                'follows.read',
                'follows.write',
                'offline.access',
                'space.read',
                'mute.read',
                'mute.write',
                'like.read',
                'like.write',
                'list.read',
                'list.write',
                'block.read',
                'block.write',
                'bookmark.read',
                'bookmark.write',
            ]
        ]; 

        $this->credentials = array(
            'bearer_token' => $this->bearer_token,
            'consumer_key' => $this->consumer_key,
            'consumer_secret' => $this->consumer_secret,
            'auth_token' => '',
            'token_identifier' => '',
            'token_secret' => '',
        );

        $this->params = [
            'expansions' => 'pinned_tweet_id',
            'user.fields' => 'id,name,url,verified,username,profile_image_url'
        ];

        $this->proxy_item = FALSE;
        $this->proxy = NULL;
        $proxy_item = asign_proxy("instagram", "profile", 1);
        if ($proxy_item) {
            $this->proxy_item = $proxy_item;
            $this->proxy = $proxy_item->proxy;
        }
    }
    
    public function index($page = "") {
        if( $page == "cookie" ){
            try {
                $twitter_csrf_token = get_session("twitter_csrf_token");
                $twitter_auth_token = get_session("twitter_auth_token");
                $twitter_session    = get_session("twitter_session");

                if(!$twitter_csrf_token || !$twitter_auth_token || !$twitter_session){
                    redirect_to( get_module_url("oauth_cookies") );
                }

                $tw_auth = new \TwitterCookieApi($twitter_csrf_token, $twitter_auth_token, $twitter_session, $this->proxy);
                $response = $tw_auth->myInfo();

                if(!is_string($response)){

                    $result = [];
                    $result[] = (object)[
                        'id' => $response->rest_id,
                        'name' => $response->legacy->name,
                        'avatar' => $response->legacy->profile_image_url_https,
                        'desc' => $response->legacy->screen_name
                    ];

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
                        "message" => $response,
                        "save_url" => ""
                    ];
                }
            } catch (Exception $e) {
                $profiles = [
                    "status" => "error",
                    "config" => $this->config,
                    "message" => $e->getMessage(),
                    "save_url" => ""
                ];
            }

        }else{
            $code = post('code');
            $state = post('state');
            $accessToken = "";
            $profiles = "";

            try {
                if(!get_session("TW_AccessToken") || get_session("TW_AccessToken") == ""){
                    if ( !isset( $code ) ) {
                        redirect_to( get_module_url("oauth") );
                    }elseif( empty( $state ) || ($state !== get_session("oauth2state")) ){
                        $profiles = [
                            "status" => "error",
                            "config" => $this->config,
                            "message" => __("Invalid state")
                        ];
                    }else{
                        $accessToken = $this->twitter->getAccessToken('authorization_code', [
                            'code' => $code,
                            'code_verifier' => get_session("oauth2verifier"),
                        ]);

                        set_session(["TW_AccessToken" => json_encode($accessToken)]);
                        $accessToken = json_encode($accessToken);
                        $accessToken = json_decode($accessToken);
                    }
                }else{
                    $accessToken = get_session("TW_AccessToken");
                    $accessToken = json_decode($accessToken);
                }

                if( post("oauth_token") && post("oauth_verifier") ){
                    
                    if(!get_session("TW_AccessToken_V1")){
                        $oauth_token = get_session("twitter_oauth_token");
                        $oauth_token_secret = get_session("twitter_oauth_token_secret");
                        $oauth_verifier = get("oauth_verifier");
                        remove_session( ["twitter_oauth_token"] );
                        remove_session( ["twitter_oauth_token_secret"] );

                        $connection = new TwitterOAuth($this->consumer_key, $this->consumer_secret, $oauth_token, $oauth_token_secret);
                        $accessToken_V1 = $connection->oauth("oauth/access_token", ["oauth_verifier" => $oauth_verifier]);
                        set_session(["TW_AccessToken_V1" => $accessToken_V1]);
                    }else{
                        $connection = new TwitterOAuth($this->consumer_key, $this->consumer_secret);
                        $accessToken_V1 = get_session("TW_AccessToken_V1");
                    }
                }else{
                    try {
                        $connection = new TwitterOAuth($this->consumer_key, $this->consumer_secret);
                        $request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => $this->callback_url));

                        set_session( ["twitter_oauth_token" => $request_token['oauth_token'] ] );
                        set_session( ["twitter_oauth_token_secret" => $request_token['oauth_token_secret'] ] );

                        $oauth_link = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
                        redirect_to($oauth_link);
                    } catch (\Exception $e) {
                        $error = json_decode($e->getMessage());
                        $profiles = [
                            "status" => "error",
                            "config" => $this->config,
                            "message" => $error->errors[0]->message,
                            "save_url" => ""
                        ];
                    }
                }
                
                if(isset($accessToken_V1)){
                    $accessToken->oauth_token = $accessToken_V1['oauth_token'];
                    $accessToken->oauth_token_secret = $accessToken_V1['oauth_token_secret'];
                    set_session(["TW_AccessToken" => json_encode($accessToken)]);

                    $this->credentials["auth_token"] = $accessToken->access_token;
                    $this->credentials["token_identifier"] = $accessToken->oauth_token;
                    $this->credentials["token_secret"] = $accessToken->oauth_token_secret;
                    $twitter = new BirdElephant($this->credentials);
                    $profile = $twitter->me()->myself($this->params);
                    $result = [];

                    if(isset($profile->data)){
                        $profile = $profile->data;
                        $result[] = (object)[
                            'id' => $profile->id,
                            'name' => $profile->name,
                            'avatar' => $profile->profile_image_url,
                            'desc' => $profile->username
                        ];
                    }

                    $profiles = [
                        "status" => "success",
                        "config" => $this->config,
                        "result" => $result,
                        "save_url" => get_module_url("save")
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
            "content" => view('Core\Twitter_profiles\Views\add', $profiles)
        ];

        return view('Core\Twitter_profiles\Views\index', $data);
    }

    public function popup_twitter_app(){
        $data = [
            'config'  => $this->config
        ];
        return view('Core\Twitter_profiles\Views\popup_twitter_app', $data);
    }

    public function save_twitter_api(){
        $twitter_status = (int)post("twitter_status");
        $twitter_client_id = post("twitter_client_id");
        $twitter_client_secret = post("twitter_client_secret");
        $twitter_bearer_token = post("twitter_bearer_token");
        $twitter_consumer_key = post("twitter_consumer_key");
        $twitter_consumer_secret = post("twitter_consumer_secret");

        update_team_data("twitter_status", $twitter_status);
        update_team_data("twitter_client_id", $twitter_client_id);
        update_team_data("twitter_client_secret", $twitter_client_secret);
        update_team_data("twitter_bearer_token", $twitter_bearer_token);
        update_team_data("twitter_consumer_key", $twitter_consumer_key);
        update_team_data("twitter_consumer_secret", $twitter_consumer_secret);

        ms([
            "status" => "success",
            "message" => __("Success")
        ]);
    }

    public function oauth(){
        $oauth_link = get_module_url("oauth_official");
        if( !get_option("twitter_cookie_status", 1) && get_option("twitter_official_status", 0) ){
            redirect_to($oauth_link);
        }

        if( !get_option("twitter_cookie_status", 1) && !get_option("twitter_official_status", 0) ){
            redirect_to( base_url("account_manager") );
        }

        $data = [
            "title" => $this->config['name'],
            "desc" => $this->config['desc'],
            "content" => view('Core\Twitter_profiles\Views\oauth', [ "config" => $this->config, "oauth_link" => $oauth_link ])
        ];

        return view('Core\Twitter_profiles\Views\index', $data);
    }

    public function oauth_official(){
        remove_session(['TW_AccessToken']);
        remove_session(['TW_AccessToken_V1']);
        try {
            $authUrl = $this->twitter->getAuthorizationUrl($this->twitter_options);
            set_session(["oauth2state" => $this->twitter->getState()]);
            set_session(["oauth2verifier" => $this->twitter->getPkceVerifier()]);
            redirect_to($authUrl);
        } catch (\Exception $e) {
            redirect_to( get_module_url("?error=twitter_error") );
        }
    }

    public function oauth_cookies(){
        try {
            $twitter_csrf_token = post("twitter_csrf_token");
            $twitter_auth_token = post("twitter_auth_token");
            $twitter_session    = post("twitter_session");

            validate('null', __('Twitter csrf token'), $twitter_csrf_token);
            validate('null', __('Twitter auth token'), $twitter_auth_token);
            validate('null', __('Twitter session'), $twitter_session);

            $tw_auth = new \TwitterCookieApi($twitter_csrf_token, $twitter_auth_token, $twitter_session, $this->proxy);
            $data = $tw_auth->myInfo();

            set_session([
                "twitter_csrf_token" => $twitter_csrf_token,
                "twitter_auth_token" => $twitter_auth_token,
                "twitter_session" => $twitter_session,
            ]);

            ms(['status' => 'success']);
        } catch (Exception $e) {
            ms([
                "status" => "error",
                "message" => $e->getMessage()
            ]);
        }
    }

    public function save()
    {
        $ids = post('id');
        $team_id = get_team("id");
        $accessToken = get_session("TW_AccessToken");
        $access_token = json_decode($accessToken);

        validate('empty', __('Please select a profile to add'), $ids);

        $this->credentials["auth_token"] = $access_token->access_token;
        $twitter = new BirdElephant($this->credentials);
        $response = $twitter->me()->myself($this->params);

        if(!is_string($response) && isset($response->data)){

            $response = $response->data;

            if(in_array($response->id, $ids)){
                $item = db_get('*', TB_ACCOUNTS, "social_network = 'twitter' AND login_type = '1' AND team_id = '{$team_id}' AND pid = '".$response->id."'");
                if(!$item){
                    //Check limit number 
                    check_number_account("twitter", "profile");
                    $avatar = save_img( $response->profile_image_url, WRITEPATH.'avatar/' );
                    $data = [
                        'ids' => ids(),
                        'module' => $this->module,
                        'social_network' => 'twitter',
                        'category' => 'profile',
                        'login_type' => 1,
                        'can_post' => 1,
                        'team_id' => $team_id,
                        'pid' => $response->id,
                        'name' => $response->name,
                        'username' => $response->username,
                        'token' => $accessToken,
                        'avatar' => $avatar,
                        'url' => 'https://twitter.com/'.$response->username,
                        'data' => NULL,
                        'status' => 1,
                        'changed' => time(),
                        'created' => time()
                    ];

                    db_insert(TB_ACCOUNTS, $data);
                }else{
                    unlink( get_file_path($item->avatar) );
                    $avatar = save_img( $response->profile_image_url, WRITEPATH.'avatar/' );
                    $data = [
                        'can_post' => 1,
                        'pid' => $response->id,
                        'name' => $response->name,
                        'username' => $response->username,
                        'token' => $accessToken,
                        'avatar' => $avatar,
                        'url' => 'https://twitter.com/'.$response->username,
                        'status' => 1,
                        'changed' => time(),
                    ];

                    db_update(TB_ACCOUNTS, $data, ['id' => $item->id]);
                }
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
    }

    public function save_cookie()
    {
        try {
            $ids = post('id');
            $team_id = get_team("id");
            $twitter_csrf_token = get_session("twitter_csrf_token");
            $twitter_auth_token = get_session("twitter_auth_token");
            $twitter_session    = get_session("twitter_session");

            if(!$twitter_csrf_token || !$twitter_auth_token || !$twitter_session){
                validate('empty', __('Cannot connect to your Twitter account'), $ids);
            }

            validate('empty', __('Please select a profile to add'), $ids);
            $tw_auth = new \TwitterCookieApi($twitter_csrf_token, $twitter_auth_token, $twitter_session, $this->proxy);
            $response = $tw_auth->myInfo();

            if(in_array($response->rest_id, $ids)){

                $accessToken = json_encode([ "twitter_csrf_token" => $twitter_csrf_token, "twitter_auth_token" => $twitter_auth_token, "twitter_session" => $twitter_session ]);

                $item = db_get('*', TB_ACCOUNTS, "social_network = 'twitter' AND login_type = '3' AND team_id = '{$team_id}' AND pid = '".$response->rest_id."'");
                if(!$item){
                    //Check limit number 
                    check_number_account("twitter", "profile");
                    $avatar = save_img( $response->legacy->profile_image_url_https, WRITEPATH.'avatar/' );
                    $data = [
                        'ids' => ids(),
                        'module' => $this->module,
                        'social_network' => 'twitter',
                        'category' => 'profile',
                        'login_type' => 3,
                        'can_post' => 1,
                        'team_id' => $team_id,
                        'pid' => $response->rest_id,
                        'name' => $response->legacy->name,
                        'username' => $response->legacy->name,
                        'token' => $accessToken,
                        'avatar' => $avatar,
                        'url' => 'https://twitter.com/'.$response->legacy->screen_name,
                        'proxy' => $this->proxy_item?$this->proxy_item->id:"",
                        'tmp' => $accessToken,
                        'data' => NULL,
                        'status' => 1,
                        'changed' => time(),
                        'created' => time()
                    ];

                    db_insert(TB_ACCOUNTS, $data);
                }else{
                    @unlink( get_file_path($item->avatar) );
                    $avatar = save_img( $response->legacy->profile_image_url_https, WRITEPATH.'avatar/' );
                    $data = [
                        'can_post' => 1,
                        'pid' => $response->rest_id,
                        'name' => $response->legacy->name,
                        'username' => $response->legacy->name,
                        'token' => $accessToken,
                        'avatar' => $avatar,
                        'url' => 'https://twitter.com/'.$response->legacy->screen_name,
                        'proxy' => $this->proxy_item?$this->proxy_item->id:"",
                        'tmp' => $accessToken,
                        'status' => 1,
                        'changed' => time(),
                    ];

                    db_update(TB_ACCOUNTS, $data, ['id' => $item->id]);
                }
            }

            remove_session(["fb_user_id", "fb_session"]);

            ms([
                "status" => "success",
                "message" => __("Success")
            ]);
        } catch (\Exception $e) {
            ms([
                "status" => "error",
                "message" => $e->getMessage()
            ]);
        }
    }
}