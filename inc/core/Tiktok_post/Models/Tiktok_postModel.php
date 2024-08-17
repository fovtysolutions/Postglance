<?php
namespace Core\Tiktok_post\Models;
use CodeIgniter\Model;

class Tiktok_postModel extends Model
{
	public function __construct(){
        $this->config = include realpath( __DIR__."/../Config.php" );
    }

    public function block_can_post(){
        return true;
    }

    public function block_plans(){
        return [
            "tab" => 10,
            "position" => 350,
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
            "position" => 350,
        	"preview" => view( 'Core\Tiktok_post\Views\preview', [ 'config' => $this->config ] ),
            //"advance_options" => view( 'Core\Tiktok_post\Views\advance_options', [ 'config' => $this->config ] )
        ];
    }

    public function post_validator($post){
        $errors = array();
        $data = json_decode( $post->data , 1);
        $medias = $data['medias'];

        if($post->social_network == 'tiktok'){
            switch ($post->type) {

                case 'text':
                    $errors[] = __("Tiktok does not support posting as text");
                    break;

                case 'link':
                    $errors[] = __("Tiktok does not support posting as link");
                    break;
                
                case 'media':
                    if(empty($data['medias'])){
                        $errors[] = __("Tiktok just support posting as video");
                    }else{
                        if(!is_video($medias[0]))
                        {
                            $errors[] = __("Tiktok just support posting as video");
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
            switch ($post->type)
            {
                case 'media':
                    if(count($medias) == 0)
                    {
                        return [
                            "status" => "error",
                            "message" => __("Cannot find the video to upload"),
                            "type" => $post->type
                        ];
                    }

                    $videoPath = get_file_path($medias[0]);

                    //Save file
                    $is_tmp_file = false;
                    if( $videoPath != "" && stripos( strtolower($videoPath) , "https://") !== false ||  stripos( strtolower($videoPath) , "http://") !== false ){
                        $is_tmp_file = true;
                        $videoPath = save_file($videoPath);
                        $videoPath = get_file_path($videoPath);
                    }
            

                    if(!is_video(get_file_url($videoPath)))
                    {
                        return [
                            "status" => "error",
                            "message" => __("Cannot find the video to upload"),
                            "type" => $post->type
                        ];
                    }
 
                    $caption = shortlink( spintax($data->caption), $shortlink_by);

                    $instance_id = $post->account->token;
                    $access_token = get_team("ids", $post->account->team_id);

                    $response = tiktok_post_curl("post", [ 
                        "instance_id" => $instance_id, 
                        "access_token" => $access_token 
                    ], [ 
                        "video_url" => $videoPath, 
                        "caption" => $caption 
                    ]);

                    if ($is_tmp_file) {
                        @unlink($videoPath);
                    }

                    if($response->status == "success"){
                        return [
                            "status" => "success",
                            "message" => __('Success'),
                            "id" => $response->id,
                            "url" => $response->link,
                            "type" => $post->type
                        ]; 
                    }else{
                        return [
                            "status" => "error",
                            "message" => $response->message,
                            "type" => $post->type
                        ];
                    }
                    break;

                    default:
                        return [
                            "status" => "error",
                            "message" => __("Cannot find the video to upload"),
                            "type" => $post->type
                        ];

            }
            
        } catch(\Exception $e) {
            return [
                "status" => "error",
                "message" => __( $e->getMessage() ),
                "type" => $post->type
            ];
        }
    }
}
