<?php
namespace Core\Telegram_channels\Controllers;

class Telegram_channels extends \CodeIgniter\Controller
{
    public function __construct(){
        $reflect = new \ReflectionClass(get_called_class());
        $this->module = strtolower( $reflect->getShortName() );
        $this->config = include realpath( __DIR__."/../Config.php" );
        include get_module_dir( __DIR__ , 'Libraries/vendor/autoload.php');
    }
    
    public function index() {

        try {
            if(!get_session("Telegram_AccessToken")){
                redirect_to( get_module_url("oauth") );
            }

            $result = [];
            $access_token = get_session("Telegram_AccessToken");
            $telegram = new \Telegram($access_token);
            $response = $telegram->getUpdates();

            if($response["ok"] == 1){

                if(!empty($response['result'])){

                    foreach ($response['result'] as $value) {
                        if(isset($value['channel_post'])){
                            $result[] = (object)[
                                'id' => $value['channel_post']['chat']['id'],
                                'name' => $value['channel_post']['chat']['title'],
                                'avatar' => get_avatar( $value['channel_post']['chat']['title'] ),
                                'desc' => isset($value['channel_post']['chat']['username'])?$value['channel_post']['chat']['username']:$value['channel_post']['chat']['title'],
                            ];                            
                        }
                    }                        
                }

                if(!empty($result)){
                    set_session(["Telegram_channels" => json_encode($result)]);
                }

                if( empty($result) && get_session("Telegram_channels") ){
                    $result = get_session("Telegram_channels");
                    $result = json_decode( $result);
                }

                if(!empty($result)){
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

            }else{
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

        $data = [
            "title" => $this->config['name'],
            "desc" => $this->config['desc'],
            "content" => view('Core\Telegram_channels\Views\add', $profiles)
        ];

        return view('Core\Telegram_channels\Views\index', $data);
    }

    public function oauth(){
        remove_session(['Telegram_AccessToken']);
        remove_session(['Telegram_channels']);

        $data = [
            "title" => $this->config['name'],
            "desc" => $this->config['desc'],
            "content" => view('Core\Telegram_channels\Views\oauth', [ "config" => $this->config ])
        ];

        return view('Core\Telegram_channels\Views\index', $data);
    }

    public function token()
    {
        try {
            $accessToken = post("access_token");

            if(empty($accessToken)){
                ms([
                    "status" => "error",
                    "message" => __('Please enter access token')
                ]);
            }
            
            $telegram = new \Telegram($accessToken);
            $response = $telegram->getMe();

            if($response['ok'] != 1){
                ms([
                    "status" => "error",
                    "message" => __("Unauthorized")
                ]);
            }

            set_session(["Telegram_AccessToken" => $accessToken]);

            ms([
                "status" => "success",
                "message" => __("Success")
            ]);
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

            $accessToken = get_session("Telegram_AccessToken");
            $response = get_session("Telegram_channels");
            $response = json_decode($response);

            if(!empty($response)){

                foreach ($response as $value) {
                    $value = (object)$value;
                    if( in_array($value->id, $ids) ){
                        
                        $item = db_get('*', TB_ACCOUNTS, "social_network = 'telegram' AND team_id = '{$team_id}' AND pid = '".$value->id."'");

                        if(!$item){
                            //Check limit number 
                            check_number_account("telegram", "channel");
                            $avatar = save_img( $value->avatar, WRITEPATH.'avatar/' );
                            $data = [
                                'ids' => ids(),
                                'module' => $this->module,
                                'social_network' => 'telegram',
                                'category' => 'channel',
                                'login_type' => 1,
                                'can_post' => 1,
                                'team_id' => $team_id,
                                'pid' => $value->id,
                                'name' => $value->name,
                                'username' => $value->desc,
                                'token' => $accessToken,
                                'avatar' => $avatar,
                                'url' => 'https://web.telegram.org/#/im?p=@'.$value->desc,
                                'data' => NULL,
                                'status' => 1,
                                'changed' => time(),
                                'created' => time()
                            ];

                            db_insert(TB_ACCOUNTS, $data);
                        }else{
                            unlink( get_file_path($item->avatar) );
                            $avatar = save_img( $value->avatar, WRITEPATH.'avatar/' );
                            $data = [
                                'can_post' => 1,
                                'pid' => $value->id,
                                'name' => $value->name,
                                'username' => $value->desc,
                                'token' => $accessToken,
                                'avatar' => $avatar,
                                'url' => 'https://web.telegram.org/#/im?p=@'.$value->desc,
                                'status' => 1,
                                'changed' => time(),
                            ];

                            db_update(TB_ACCOUNTS, $data, ['id' => $item->id]);
                        }
                    }
                }
            }

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