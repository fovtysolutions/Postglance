<?php
namespace Core\Google_business_profiles\Controllers;

class Google_business_profiles extends \CodeIgniter\Controller
{
    public function __construct(){
        $reflect = new \ReflectionClass(get_called_class());
        $this->module = strtolower( $reflect->getShortName() );
        $this->config = include realpath( __DIR__."/../Config.php" );
        include get_module_dir( __DIR__ , 'Libraries/vendor/autoload.php');
        $client_id = get_option('gmb_client_id', '');
        $client_secret = get_option('gmb_api_secret', '');
        $api_key = get_option('gmb_api_key', '');

        if($client_id == "" || $client_secret == "" || $api_key == ""){
            redirect_to( base_url("social_network_settings/index/".$this->config['parent']['id']) ); 
        }

        $this->client = new \Google\Client();
        $this->client->setAccessType("offline");
        $this->client->setApprovalPrompt("force");
        $this->client->setApplicationName("GMB");
        $this->client->setClientId( $client_id );
        $this->client->setClientSecret( $client_secret );
        $this->client->setRedirectUri(get_module_url());
        $this->client->setDeveloperKey( $api_key );
        $this->client->setScopes(
            [
                'https://www.googleapis.com/auth/plus.business.manage',
                'https://www.googleapis.com/auth/business.manage',
                'https://www.googleapis.com/auth/userinfo.email'
            ]
        );
    }
    
    public function index() {

        try {
            if( !get_session("GMB_AccessToken") ){
                $this->client->authenticate( post("code") );
                $oauth2 = new \Google_Service_Oauth2($this->client);
                $accessToken = $this->client->getAccessToken();
                set_session(["GMB_AccessToken" => json_encode($accessToken)]);
            }else{
                $accessToken = get_session("GMB_AccessToken");
                $accessToken = json_decode($accessToken, true);
            }

            $optional_params = [];
            $optional_params['pageSize'] = 100;
            $optional_params['readMask'] = ['name', 'title', 'storefrontAddress', 'latlng', 'phoneNumbers', 'Metadata'];
            
            $this->client->setAccessToken($accessToken);
            $this->gmb = new \Google_Service_MyBusinessBusinessInformation($this->client);
            $this->gmb_manage = new \Google_Service_MyBusinessAccountManagement($this->client);

            $locations = [];
            $accountsList = $this->gmb_manage->accounts->listAccounts()->getAccounts();
            
            if ( $accountsList ) {
                $location_list = $this->gmb->accounts_locations->listAccountsLocations($accountsList[0]->name,$optional_params)->getLocations(); 

                if ($location_list) {
                    $locations = $location_list;
                }
            }

            $result = [];
            if(!empty($locations))
            {
                foreach ($locations as $key => $row)
                {

                    //pr($row->getMetaData()->getMapsUrl(),1);
                    //if($row->getLocationState()->getIsVerified() == 1)
                    //{
                        $result[] = (object)[
                            'id' => $row->getName(),
                            'name' => $row->getTitle(),
                            'avatar' => "https://ui-avatars.com/api?name=".$row->getTitle()."&size=128&background=4b88ef&color=fff",
                            'desc' => $row->getTitle()
                        ];
                    //}
                }

                $profiles = [
                    "status" => "success",
                    "config" => $this->config,
                    "result" => $result
                ];
            }

            if(count($result) == 0){
                $profiles = [
                    "status" => "error",
                    "config" => $this->config,
                    "message" => __('No profile to add')
                ];
            }
        } catch (\Exception $e) {

            $message = json_decode($e->getMessage());

            if($message){
                $message = $message->error->message;
            }else{
                $message = $e->getMessage();
            }

            $profiles = [
                "status" => "error",
                "config" => $this->config,
                "message" => $message
            ];
        }

        $data = [
            "title" => $this->config['name'],
            "desc" => $this->config['desc'],
            "content" => view('Core\Google_business_profiles\Views\add', $profiles)
        ];

        return view('Core\Google_business_profiles\Views\index', $data);
    }

    public function oauth(){
        remove_session(["GMB_AccessToken"]);
        $oauth_link = $this->client->createAuthUrl();
        redirect_to($oauth_link);
    }

    public function save()
    {
        try {
            
            $ids = post('id');
            $team_id = get_team("id");
            $accessToken = get_session("GMB_AccessToken");
            $accessToken = json_decode( $accessToken , true);

            validate('empty', __('Please select a profile to add'), $ids);

            $this->client->setAccessToken($accessToken);
            $this->gmb = new \Google_Service_MyBusinessBusinessInformation($this->client);
            $this->gmb_manage = new \Google_Service_MyBusinessAccountManagement($this->client);

            $optional_params = [];
            $optional_params['pageSize'] = 100;
            $optional_params['readMask'] = ['name', 'title', 'storefrontAddress', 'latlng', 'phoneNumbers', 'Metadata'];

            $locations = [];
            $accountsList = $this->gmb_manage->accounts->listAccounts()->getAccounts();
            if ( $accountsList ) {
                $location_list = $this->gmb->accounts_locations->listAccountsLocations($accountsList[0]->name,$optional_params)->getLocations(); 
                if ($location_list) {
                    $locations = $location_list;
                }
            }

            if(!empty($locations))
            {
                foreach ($locations as $key => $row)
                {
                    if(in_array($row->getName(), $ids, true))
                    {
                        $item = db_get('*', TB_ACCOUNTS, "social_network = 'google_business_profile' AND team_id = '{$team_id}' AND pid = '".$row->getName()."'");
                        if(!$item){
                            //Check limit number 
                            check_number_account("google_business_profile", "profile");
                            $avatar = get_avatar( $row->getTitle() );
                            $avatar = save_img( $avatar, WRITEPATH.'avatar/' );
                            $data = [
                                'ids' => ids(),
                                'module' => $this->module,
                                'social_network' => 'google_business_profile',
                                'category' => 'profile',
                                'login_type' => 1,
                                'can_post' => 1,
                                'team_id' => $team_id,
                                'pid' => $row->getName(),
                                'name' => $row->getTitle(),
                                'username' => $accountsList[0]->name."/".$row->getName(),
                                'token' => json_encode( $accessToken ),
                                'avatar' => $avatar,
                                'url' => $row->getMetaData()->getMapsUri(),
                                'data' => NULL,
                                'status' => 1,
                                'changed' => time(),
                                'created' => time()
                            ];

                            db_insert(TB_ACCOUNTS, $data);
                        }else{
                            unlink( get_file_path($item->avatar) );
                            $avatar = get_avatar( $row->getTitle() );
                            $avatar = save_img( $avatar, WRITEPATH.'avatar/' );
                            $data = [
                                'can_post' => 1,
                                'pid' => $row->getName(),
                                'name' => $row->getTitle(),
                                'username' => $accountsList[0]->name."/".$row->getName(),
                                'token' => json_encode( $accessToken ),
                                'avatar' => $avatar,
                                'url' => $row->getMetaData()->getMapsUri(),
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
                    "message" => $response
                ]);
            }
        } catch (\Exception $e) {
            $message = json_decode($e->getMessage());

            if(isset($message->error)){
                ms([
                    "status" => "error",
                    "message" => $message->error->message
                ]);
            }else{
                ms([
                    "status" => "error",
                    "message" => $e->getMessage()
                ]);
            }
        }
    }
}