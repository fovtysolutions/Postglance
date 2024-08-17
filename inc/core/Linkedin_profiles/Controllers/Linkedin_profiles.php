<?php
namespace Core\Linkedin_profiles\Controllers;
use myPHPnotes\LinkedIn;

class Linkedin_profiles extends \CodeIgniter\Controller
{
    public function __construct(){
        $reflect = new \ReflectionClass(get_called_class());
        $this->module = strtolower( $reflect->getShortName() );
        $this->config = include realpath( __DIR__."/../Config.php" );
        include get_module_dir( __DIR__ , 'Libraries/LinkedIn.php');
        $app_id = get_option('linkedin_api_key', '');
        $app_secret = get_option('linkedin_api_secret', '');
        $app_callback = get_module_url();

        if(get("error") == "unauthorized_scope_error"){
            set_session(["linkedin_scopes" => "r_emailaddress r_liteprofile w_member_social"]);
            redirect_to( get_module_url("oauth") );
        }else{
            $app_scopes = "r_basicprofile w_member_social w_organization_social r_organization_social rw_organization_admin";
            if(get_session('linkedin_scopes')){
                 $app_scopes = get_session('set_session');
            }
        }
        
        $ssl = false;

        if($app_id == "" || $app_secret == ""){
            redirect_to( base_url("social_network_settings/index/".$this->config['parent']['id']) ); 
        }

        $this->linkedin = new LinkedIn($app_id, $app_secret, $app_callback, $app_scopes, $ssl);
    }
    
    public function index() {

        try {
            if(!get_session("Linkedin_AccessToken")){
                $response = $this->linkedin->getAccessToken( post('code') );
                if ( $response['status'] == "success" ) {
                    $access_token = $response['accessToken'];
                    set_session(["Linkedin_AccessToken" => $response['accessToken']]);
                }else{
                    $access_token = false;
                }
            }else{
                $access_token = get_session("Linkedin_AccessToken");
            }

            if($access_token){
                $response = $this->linkedin->getPerson($access_token);

                $firstName_param = (array)$response->firstName->localized;
                $lastName_param = (array)$response->lastName->localized;

                $firstName = reset($firstName_param);
                $lastName = reset($lastName_param);
                $fullname = $firstName." ".$lastName;

                $avatar = (array)$response->profilePicture; 
                $avatar = $avatar['displayImage~']->elements[0]->identifiers[0]->identifier;

                $result = [];
                $result[] = (object)[
                    'id' => $response->id,
                    'name' => $fullname,
                    'avatar' => $avatar,
                    'desc' => $fullname
                ];

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
        } catch (\Exception $e) {
            pr($e,1);
            $profiles = [
                "status" => "error",
                "config" => $this->config,
                "message" => $e->getMessage()
            ];
        }

        $data = [
            "title" => $this->config['name'],
            "desc" => $this->config['desc'],
            "content" => view('Core\Linkedin_profiles\Views\add', $profiles)
        ];

        return view('Core\Linkedin_profiles\Views\index', $data);
    }

    public function oauth(){
        remove_session(['Linkedin_AccessToken']);
        redirect_to($this->linkedin->getAuthUrl());
    }

    public function save()
    {
        $ids = post('id');
        $team_id = get_team("id");
        $accessToken = get_session('Linkedin_AccessToken');

        validate('empty', __('Please select a profile to add'), $ids);

        $response = $this->linkedin->getPerson($accessToken);

        if( isset($response->status) ){
            ms([
                "status" => "error",
                "message" => __( $response->message )
            ]);
        }

        if(!is_string($response)){

            if(in_array($response->id, $ids)){

                $vanityName = "";
                if(isset($response->vanityName)){
                    $vanityName = $response->vanityName;
                }

                $firstName_param = (array)$response->firstName->localized;
                $lastName_param = (array)$response->lastName->localized;

                $firstName = reset($firstName_param);
                $lastName = reset($lastName_param);
                $fullname = $firstName." ".$lastName;

                $item = db_get('*', TB_ACCOUNTS, "social_network = 'linkedin' AND team_id = '{$team_id}' AND pid = '".$response->id."'");
                if(!$item){

                    //Check limit number 
                    check_number_account("linkedin", "profile");
                    $avatar = (array)$response->profilePicture; 
                    $avatar = $avatar['displayImage~']->elements[0]->identifiers[0]->identifier;
                    $avatar = save_img( $avatar, WRITEPATH.'avatar/' );
                    $data = [
                        'ids' => ids(),
                        'module' => $this->module,
                        'social_network' => 'linkedin',
                        'category' => 'profile',
                        'login_type' => 1,
                        'can_post' => 1,
                        'team_id' => $team_id,
                        'pid' => $response->id,
                        'name' => $fullname,
                        'username' => $fullname,
                        'token' => $accessToken,
                        'avatar' => $avatar,
                        'url' => 'https://linkedin.com/in/'.$vanityName,
                        'tmp' => $response->id,
                        'data' => NULL,
                        'status' => 1,
                        'changed' => time(),
                        'created' => time()
                    ];

                    db_insert(TB_ACCOUNTS, $data);
                }else{
                    unlink( get_file_path($item->avatar) );
                    $avatar = (array)$response->profilePicture; 
                    $avatar = $avatar['displayImage~']->elements[0]->identifiers[0]->identifier;
                    $avatar = save_img( $avatar, WRITEPATH.'avatar/' );

                    $data = [
                        'can_post' => 1,
                        'pid' => $response->id,
                        'name' => $fullname,
                        'username' => $fullname,
                        'token' => $accessToken,
                        'avatar' => $avatar,
                        'url' => 'https://linkedin.com/in/'.$vanityName,
                        'tmp' => $response->id,
                        'status' => 1,
                        'changed' => time(),
                    ];

                    db_update(TB_ACCOUNTS, $data, ['id' => $item->id]);
                }

                db_update(TB_ACCOUNTS, ["token" => $accessToken], ["tmp" => $response->id]);
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
}