<?php
namespace Core\Vk_post\Models;
use CodeIgniter\Model;

class Vk_postModel extends Model
{
    public function __construct(){
        $this->config = include realpath( __DIR__."/../Config.php" );
        include get_module_dir( __DIR__ , 'Libraries/vkapi.php');

        $this->app_id = get_option('vk_app_id', '');
        $this->secure_secret = get_option('vk_secure_secret', '');
        $this->vk = new \Vkapi($this->app_id, $this->secure_secret); 
    }

    public function block_can_post(){
        return true;
    }

    public function block_plans(){
        return [
            "tab" => 10,
            "position" => 1200,
            "permission" => true,
            "label" => __("Planning and Scheduling"),
            "items" => [
                [
                    "id" => $this->config['id'],
                    "name" => sprintf(__("%s scheduling & report"), $this->config['name']),
                ]
            ]
        ];
    }

    public function block_frame_posts($path = ""){
        return [
            "position" => 900,
            "preview" => view( 'Core\Vk_post\Views\preview', [ 'config' => $this->config ] )
        ];
    }

    public function post_validator($post){
        $errors = array();
        $data = json_decode( $post->data , 1);
        $medias = $data['medias'];

        if($post->social_network == 'vk'){
            switch ($post->type) {
                case 'media':
                    if(empty($data['medias'])){
                        $errors[] = __("VKontakte just support posting as image or video");
                    }else{
                        if(!is_image($medias[0]) && !is_video($medias[0]))
                        {
                            $errors[] = __("VKontakte just support posting as image or video");
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

        $params = [];
        try {

            $this->vk->set_access_token($post->account->token);
            $caption = urlencode( shortlink( spintax($data->caption), $shortlink_by) );
            $shortlink = shortlink($data->link, $shortlink_by);
            if($shortlink != ""){
                $link = urlencode( $shortlink );
            }else{
                $link = "";
            }

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
                        $images = array();
                        foreach ($medias as $key => $media){
                            $media = watermark($media, $post->account->team_id, $post->account->id);
                            $medias[$key] = $media;
                            if(is_image($media)){
                                $images[] = $media;
                            }
                        }

                        $attachments = $this->vk->upload_photo(0, $images, false);

                        $params = [
                            'owner_id' => $post->account->pid, 
                            'message' => $caption, 
                            'attachments' => $attachments
                        ];
                    }

                    if(is_video($medias[0]))
                    {
                        $attachments = $this->vk->upload_video([
                            'name' => '',
                            'description' => $caption,
                            'wallpost' => 1
                        ], $medias[0]);

                        $params = [
                            'owner_id' => $post->account->pid, 
                            'message' => $caption, 
                            'attachments' => $attachments
                        ];
                    }
                    break;

                case 'link':
                    
                    $params = [
                        'owner_id' => $post->account->pid, 
                        'message' => $caption,
                        'attachments' => $link
                    ];

                    break;

                case 'text':

                    $params = [
                        'owner_id' => $post->account->pid, 
                        'message' => $caption
                    ];

                    break;
                
            }

            $response = $this->vk->curl_post("wall.post", $params);
            unlink_watermark($medias);

            if(isset($response->post_id)){
                $post_id =  $response->post_id;
                return [
                    "status" => "success",
                    "message" => __('Success'),
                    "id" => $post_id,
                    "url" => "https://vk.com/wall".$post->account->pid."_".$post_id,
                    "type" => $post->type
                ]; 

            }else{

                if(isset($response->error)  && isset($response->error->error_msg)){
                    return [
                        "status"  => "error",
                        "message" => __($response->error->error_msg),
                        "type" => $post->type
                    ];
                }

                return [
                    "status"  => "error",
                    "message" => __("Unknown error"),
                    "type" => $post->type
                ];
            }

        } catch (\Exception $e) {
            return [
                "status"  => "error",
                "message" => __( $e->getMessage() ),
                "type" => $post->type
            ];
        }
    }
}
