<?php
namespace Core\Telegram_post\Models;
use CodeIgniter\Model;

class Telegram_postModel extends Model
{
	public function __construct(){
        $this->config = include realpath( __DIR__."/../Config.php" );
        include get_module_dir( __DIR__ , 'Libraries/vendor/autoload.php');
    }

    public function block_can_post(){
        return true;
    }

    public function block_plans(){
        return [
            "tab" => 10,
            "position" => 1000,
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
            "position" => 900,
        	"preview" => view( 'Core\Telegram_post\Views\preview', [ 'config' => $this->config ] )
        ];
    }

    public function post_validator($post){
        $errors = array();
        $data = json_decode( $post->data , 1);
        $medias = $data['medias'];

        if($post->social_network == 'telegram'){
            switch ($post->type) {
                case 'media':
                    if(!empty($data['medias'])){
                        if(!is_image($medias[0]) && !is_video($medias[0]))
                        {
                            $errors[] = __("Telegram just support posting as image or video");
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

        try {

            $telegram = new \Telegram($post->account->token);
            $params = [ "chat_id" => $post->account->pid ];
            $caption = shortlink( spintax($data->caption), $shortlink_by );
            $link = shortlink( $data->link, $shortlink_by );

            switch ($post->type)
            {
                case 'media':
                    if(count($medias) == 0 || (!is_image($medias[0]) && !is_video($medias[0])))
                    {
                        return [
                            "status" => "error",
                            "message" => __("Cannot find the media to upload"),
                            "type" => $post->type
                        ];
                    }

                    if(is_image($medias[0]))
                    {
                        $medias[0] = watermark($medias[0], $post->account->team_id, $post->account->id);
                        $content = ['chat_id' => $post->account->pid, 'photo' => get_file_url($medias[0]) ];
                        $response = $telegram->sendPhoto($content);

                        $params["text"] = $caption;
                        $telegram->sendMessage($params);
                        unlink_watermark($medias);
                    }

                    if(is_video($medias[0]))
                    {
                        $medias[0] = watermark($medias[0], $post->account->team_id, $post->account->id);
                        $content = ['chat_id' => $post->account->pid, 'photo' => get_file_url($medias[0]) ];
                        $response = $telegram->sendPhoto($content);

                        $params["text"] = $caption;
                        $telegram->sendMessage($params);
                        unlink_watermark($medias);
                    }
                    break;

                case 'link':
                    $params["text"] = $caption." \n\r".$link;
                    $response = $telegram->sendMessage($params);
                    break;

                case 'text':
                    $params["text"] = $caption;
                    $response = $telegram->sendMessage($params);
                    break;
                
            }

            if($response['ok'] == 1){
                if(isset($response['result']['chat']['username'])){
                    return [
                        "status" => "success",
                        "message" => __('Success'),
                        "id" => $response['result']['message_id'],
                        "url" => "https://web.telegram.org/#/im?p=@".$response['result']['chat']['username'],
                        "type" => $post->type
                    ]; 
                }else{
                    return [
                        "status" => "success",
                        "message" => __('Success'),
                        "id" => $response['result']['message_id'],
                        "url" => "https://web.telegram.org/#/im?p=@".$response['result']['from']['username'],
                        "type" => $post->type
                    ]; 
                }
            }else{
                if($response['error_code'] == 401){
                    $this->model->update($this->tb_account_manager, [ "status" => 0 ], [ "id" => $post->account->id ] );
                }

                return [
                    "status" => "error",
                    "message" => __( $response['description'] ),
                    "type" => $post->type
                ];
            }
        } catch (\Exception $e) {
            unlink_watermark($medias);
            return [
                "status"  => "error",
                "message" => $e->getMessage(),
                "type" => $post->type
            ];

        }
    }
}
