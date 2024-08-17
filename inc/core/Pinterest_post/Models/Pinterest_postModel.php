<?php
namespace Core\Pinterest_post\Models;
use CodeIgniter\Model;
use \seregazhuk\PinterestBot\Factories\PinterestBot;
use DirkGroenen\Pinterest\Pinterest;

class Pinterest_postModel extends Model
{
	public function __construct(){
        $this->config = include realpath( __DIR__."/../Config.php" );
        include get_module_dir( __DIR__ , 'Libraries/vendor/autoload.php');
        include get_module_dir( __DIR__ , 'Libraries/pinterest_api.php');
    
        $this->app_id = get_option('pinterest_app_id', '');
        $this->app_secret = get_option('pinterest_app_secret', '');
        $this->bot = PinterestBot::create();
    }

    public function block_can_post(){
        return true;
    }

    public function block_plans(){
        return [
            "tab" => 10,
            "position" => 700,
            "permission" => true,
            "label" => __("Planning and Scheduling"),
            "items" => [
                [
                    "id" => $this->config['id'],
                    "name" => sprintf("%s scheduling & report", $this->config['name']),
                ]
            ]
        ];
    }

    public function block_frame_posts($path = ""){
        return [
            "position" => 600,
        	"preview" => view( 'Core\Pinterest_post\Views\preview', [ 'config' => $this->config ] ),
            "advance_options" => view( 'Core\Pinterest_post\Views\advance_options', [ 'config' => $this->config ] )
        ];
    }

    public function post_validator($post){
        $errors = array();
        $data = json_decode( $post->data , 1);
        $medias = $data['medias'];

        if($post->social_network == 'pinterest'){
            switch ($post->type) {

                case 'text':
                    $errors[] = __("Pinterest does not support posting as text");
                    break;

                case 'link':
                    if(empty($data['medias'])){
                        $errors[] = __("Pinterest requires an image");
                    }
                    break;
                
                case 'media':
                    if(empty($data['medias'])){
                        $errors[] = __("Linkedin requires an image");
                    }else{
                        if(!is_image($medias[0]))
                        {
                            $errors[] = __("Linkedin requires an image");
                        }
                    }
                    break;
            }
        }

        return $errors;
    }

    public function post_handler($post){
        $data = json_decode($post->data, false);
        $medias = $data->medias;
        $shortlink_by = shortlink_by($data);

        try
        {
            $caption = shortlink( spintax($data->caption), $shortlink_by );
            switch ($post->account->login_type) {
                case 1:
                    try { 
                        $access_token = json_decode($post->account->token);
                        $pinterest = new \Pinterest_API($this->app_id, $this->app_secret);
                        $new_access_token = $pinterest->renew_access_token($access_token->refresh_token);
                        $pinterest->set_access_token($new_access_token->access_token);

                        $params = [
                            "board_id"      => $post->account->pid,
                            "media_source"  => [
                                "source_type" => "image_url",
                                "url" => get_file_url($medias[0])
                            ],
                            "description" => $caption,
                        ];

                        if( isset( $data->advance_options ) && isset( $data->advance_options->pinterest_link ) && $data->advance_options->pinterest_link != "" ){
                            $params["link"] = shortlink($data->advance_options->pinterest_link, $shortlink_by);
                        }

                        if( isset( $data->advance_options ) && isset( $data->advance_options->pinterest_title ) && $data->advance_options->pinterest_title != "" ){
                            $params["title"] = $data->advance_options->pinterest_title;
                            $params["alt_text"] = $data->advance_options->pinterest_title;
                        }

                        $headers = [ 'Content-Type: application/json' ];

                        $response = $pinterest->post( "pins", $params, $headers );
                        $response = (object)$response;

                        if(isset($response->id)){
                            return [
                                "status" => "success",
                                "message" => __('Success'),
                                "id" => $response->id,
                                "url" => "https://www.pinterest.com/pin/".$response->id."/",
                                "type" => $post->type
                            ]; 
                        }else if( isset($response->message) ){
                            if(isset($response->code) && $response->code == 401){
                                db_update(TB_ACCOUNTS, [ "status" => 0 ], [ "id" => $post->account->id ] );
                            }

                            return array(
                                "status"  => "error",
                                "message" => $response->message,
                                "type" => $post->type
                            );
                        }else{
                            return array(
                                "status"  => "error",
                                "message" => __("Unknown error"),
                                "type" => $post->type
                            );
                        }
                    } catch (Exception $e) {
                        if($e->getCode() == 401){
                            db_update(TB_ACCOUNTS, [ "status" => 0 ], [ "id" => $post->account->id ] );
                        }

                        $error = explode(": ", $e->getMessage());
                        return array(
                            "status"  => "error",
                            "message" => end($error),
                            "type" => $post->type
                        );
                    }
                    break;

                case 2:
                    try {
                        $this->proxy($post->account->proxy);
                        $this->bot->getHttpClient()->setCookiesPath(WRITEPATH."pinterest/");
                        $access_token = (object)unserialize($post->account->token);
                        $this->bot->auth->login($access_token->username, encrypt_decode($access_token->password));
                    } catch (Exception $e) {
                        //db_update(TB_ACCOUNTS, [ "status" => 0 ], [ "id" => $post->account->id ] );
                        return array(
                            "status"  => "error",
                            "message" => $e->getMessage(),
                            "type" => $post->type
                        );
                    }
                    
                    try {
                        $link = "";
                        if( isset( $data->advance_options ) && isset( $data->advance_options->pinterest_link ) && $data->advance_options->pinterest_link != "" ){
                            $link = shortlink($data->advance_options->pinterest_link, $shortlink_by);
                        }

                        $title = "";
                        if( isset( $data->advance_options ) && isset( $data->advance_options->pinterest_title ) && $data->advance_options->pinterest_title != "" ){
                            $title = $data->advance_options->pinterest_title;
                        }

                        $medias[0] = watermark($medias[0], $post->account->team_id, $post->account->id);
                        $response = $this->bot->pins->create(
                            get_file_url($medias[0]),
                            $post->account->pid,
                            $caption,
                            $link,
                            $title
                        );

                        if(!empty($response)){
                            $response = (object)$response;
                            return [
                                "status" => "success",
                                "message" => __('Success'),
                                "id" => $response->id,
                                "url" => "https://www.pinterest.com/pin/".$response->id,
                                "type" => $post->type
                            ]; 
                        }

                        return array(
                            "status"  => "error",
                            "message" => __("Image does not exist"),
                            "type" => $post->type
                        );
                        
                    } catch (Exception $e) {
                        return array(
                            "status"  => "error",
                            "message" => $e->getMessage(),
                            "type" => $post->type
                        );
                    }

                    break;
            }

        } catch(\Exception $e) {
            return [
                "status" => "error",
                "message" => __( $e->getMessage() ),
                "type" => $post->type
            ];
        }
    }

    public function proxy($proxy){
        $proxy = get_proxy($proxy);

        if($proxy){
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
