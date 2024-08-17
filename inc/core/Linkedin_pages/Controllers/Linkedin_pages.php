<?php
namespace Core\Linkedin_pages\Controllers;
use myPHPnotes\LinkedIn;

class Linkedin_pages extends \CodeIgniter\Controller
{
    public function __construct(){
        $reflect = new \ReflectionClass(get_called_class());
        $this->module = strtolower( $reflect->getShortName() );
        $this->config = include realpath( __DIR__."/../Config.php" );
        include get_module_dir( __DIR__ , 'Libraries/LinkedIn.php');
        $app_id = get_option('linkedin_api_key', '');
        $app_secret = get_option('linkedin_api_secret', '');
        $app_callback = get_module_url();
        $app_scopes = "r_basicprofile w_member_social w_organization_social r_organization_social rw_organization_admin";
        $ssl = false;

        if($app_id == "" || $app_secret == ""){
            redirect_to( base_url("social_network_settings/index/".$this->config['parent']['id']) ); 
        }

        $this->linkedin = new LinkedIn($app_id, $app_secret, $app_callback, $app_scopes, $ssl);
    }
    
    public function index() {

       try {
    if (!get_session("Linkedin_AccessToken")) {
        $response = $this->linkedin->getAccessToken(post('code'));
        if ($response['status'] == "success") {
            $accessToken = $response['accessToken'];
            set_session(["Linkedin_AccessToken" => $response['accessToken']]);
        } else {
            $accessToken = false;
        }
    } else {
        $accessToken = get_session("Linkedin_AccessToken");
    }

    $result = [];

    if ($accessToken) {
        $response = $this->linkedin->getCompanyPages($accessToken);

        if (isset($response->elements)) {
            foreach ($response->elements as $row) {
                $row = (array) $row;
                $row = $row['organizationalTarget~'];

                // Initialize avatar
                $avatar = null;
                
                // Check if logoV2 exists and handle its presence
                if (isset($row->logoV2)) {
                    $logoV2 = (array) $row->logoV2;
                    if (isset($logoV2['original~'])) {
                        $avatar = (array) $logoV2['original~'];
                        if (isset($avatar['elements'][0]->identifiers[0]->identifier)) {
                            $avatar = $avatar['elements'][0]->identifiers[0]->identifier;
                        }
                    }
                }

                $result[] = (object) [
                    'id' => $row->id,
                    'name' => $row->localizedName,
                    'avatar' => $avatar,
                    'desc' => $row->vanityName
                ];
            }

            $profiles = [
                "status" => "success",
                "config" => $this->config,
                "result" => $result
            ];

        } else {
            $profiles = [
                "status" => "error",
                "config" => $this->config,
                "message" => __('No profile to add')
            ];
        }
    } else {
        $profiles = [
            "status" => "error",
            "config" => $this->config,
            "message" => __('No profile to add')
        ];
    }
} catch (\Exception $e) {
    $profiles = [
        "status" => "error",
        "config" => $this->config,
        "message" => $e->getMessage()
    ];
}

// Now you can return or use $profiles as needed


// Now you can return or use $profiles as needed


        $data = [
            "title" => $this->config['name'],
            "desc" => $this->config['desc'],
            "content" => view('Core\Linkedin_pages\Views\add', $profiles)
        ];

        return view('Core\Linkedin_pages\Views\index', $data);
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

        $response = $this->linkedin->getCompanyPages($accessToken);
        $profile = $this->linkedin->getPerson($accessToken);

        if( isset($response->status) ){
            ms([
                "status" => "error",
                "message" => __( $response->message )
            ]);
        }

        if(!is_string($response)){

            if(isset($response->elements)){

                foreach ($response->elements as $row) {
                    $row = (array)$row;
                    $row = $row['organizationalTarget~'];
                    if(in_array($row->id, $ids)){
                        $item = db_get('*', TB_ACCOUNTS, "social_network = 'linkedin' AND team_id = '{$team_id}' AND pid = '".$row->id."'");
                        if(!$item){
                            //Check limit number 
                            check_number_account("linkedin", "page");
                            $avatar = (array)$row->logoV2;
                            $avatar = $avatar['original~'];
                            $avatar = $avatar->elements[0]->identifiers[0]->identifier;
                            $avatar = save_img( $avatar, WRITEPATH.'avatar/' );
                            $data = [
                                'ids' => ids(),
                                'module' => $this->module,
                                'social_network' => 'linkedin',
                                'category' => 'page',
                                'login_type' => 1,
                                'can_post' => 1,
                                'team_id' => $team_id,
                                'pid' => $row->id,
                                'name' => $row->localizedName,
                                'username' => $row->vanityName,
                                'token' => $accessToken,
                                'avatar' => $avatar,
                                'url' => 'https://linkedin.com/company/'.$row->id,
                                'tmp' => $profile->id,
                                'data' => NULL,
                                'status' => 1,
                                'changed' => time(),
                                'created' => time()
                            ];

                            db_insert(TB_ACCOUNTS, $data);
                        }else{
                            unlink( get_file_path($item->avatar) );
                            $avatar = (array)$row->logoV2;
                            $avatar = $avatar['original~'];
                            $avatar = $avatar->elements[0]->identifiers[0]->identifier;
                            $avatar = save_img( $avatar, WRITEPATH.'avatar/' );
                            $data = [
                                'can_post' => 1,
                                'pid' => $row->id,
                                'name' => $row->localizedName,
                                'username' => $row->vanityName,
                                'token' => $accessToken,
                                'avatar' => $avatar,
                                'url' => 'https://linkedin.com/company/'.$row->id,
                                'tmp' => $profile->id,
                                'status' => 1,
                                'changed' => time(),
                            ];

                            db_update(TB_ACCOUNTS, $data, ['id' => $item->id]);
                        }

                    }
                }

                db_update(TB_ACCOUNTS, ["token" => $accessToken], ["tmp" => $profile->id]);

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
    }
}