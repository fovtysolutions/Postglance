<?php
namespace Core\Linkedin_post\Models;
use CodeIgniter\Model;

class Linkedin_postModel extends Model
{
	public function __construct(){
        $this->config = include realpath( __DIR__."/../Config.php" );
        include get_module_dir( __DIR__ , 'Libraries/LinkedIn.php');
    
        $app_id = get_option('linkedin_api_key', '');
        $app_secret = get_option('linkedin_api_secret', '');
        $app_callback = get_module_url();
        $app_scopes = "r_emailaddress r_basicprofile r_liteprofile w_member_social rw_company_admin w_share";
        $ssl = false;

        $this->linkedin = new \LinkedIn($app_id, $app_secret, $app_callback, $app_scopes, $ssl);       
    }

    public function block_can_post(){
        return true;
    }

    public function block_plans(){
        return [
            "tab" => 10,
            "position" => 600,
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
            "position" => 600,
        	"preview" => view( 'Core\Linkedin_post\Views\preview', [ 'config' => $this->config ] )
        ];
    }

    public function post_validator($post){
        $errors = array();
        $data = json_decode( $post->data , 1);
        $medias = $data['medias'];

        if($post->social_network == 'linkedin'){
            switch ($post->type) {
            
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
        $access_token = $post->account->token;
        $shortlink_by = shortlink_by($data);

        try
        {
            if($post->account->category == "page"){
                $this->linkedin->setType("urn:li:organization:");
            }

            $caption = shortlink( spintax($data->caption), $shortlink_by );
            $link = shortlink( $data->link, $shortlink_by );

            switch ($post->type)
            {
                case 'media':
                    if(count($medias) == 0)
                    {
                        return [
                            "status" => "error",
                            "message" => __("Cannot find the image to upload"),
                            "type" => $post->type
                        ];
                    }

                    if(!is_image($medias[0]))
                    {
                        return [
                            "status" => "error",
                            "message" => __("Cannot find the image to upload"),
                            "type" => $post->type
                        ];
                    }

                    if(count($medias) == 1){
                        $medias[0] = watermark($medias[0], $post->team_id, $post->account->id);

                        $medias[0] == get_file_path($medias[0]);
                        if( stripos( strtolower($medias[0]) , "https://") !== false ||  stripos( strtolower($medias[0]) , "http://") !== false ){
                            $medias[0] = save_img($medias[0], TMPPATH());
                        }

                        $response = $this->linkedin->linkedInPhotoPost($access_token, $post->account->pid, $caption, get_file_path($medias[0]), "", "");
                    }else{
                        $media_paths = [];
                        foreach ($medias as $key => $media) {
                            $media == get_file_path($media);
                            if( stripos( strtolower($media) , "https://") !== false ||  stripos( strtolower($media) , "http://") !== false ){
                                $media = save_img($media, TMPPATH());
                            }
                                
                            $media = watermark($media, $post->team_id, $post->account->id);
                            $media_paths[] = [
                                "title" => "",
                                "desc" => "",
                                "image_path" => get_file_path($media)
                            ];
                        }

                        $response = $this->linkedin->linkedInMultiplePhotosPost($access_token, $post->account->pid, $caption, $media_paths);
                        unlink_watermark($medias);
                    }

                    break;

                case 'link':
                    $link_info = get_link_info($data->link);
                    $response = $this->linkedin->linkedInLinkPost($access_token, $post->account->pid, $caption, $link_info['title'], $link_info['description'], $link);
                    break;

                case 'text':
                    $response = $this->linkedin->linkedInTextPost($access_token, $post->account->pid, $caption);
                    break;

            }

            $response = json_decode($response);
            if( isset($response->id) ){

                return [
                    "status" => "success",
                    "message" => __('Success'),
                    "id" => $response->id,
                    "url" => "https://www.linkedin.com/feed/update/".$response->id,
                    "type" => $post->type
                ]; 

            }else{
                if(isset($response->status) &&  ($response->status == 401 || $response->status == 403) ){
                    db_update(TB_ACCOUNTS, [ "status" => 0 ], [ "id" => $post->account->id ] );
                }

                $error = explode(" :: ", $response->message);
                $error = end($error);
                $error = str_replace("\"", "", $error);

                return [
                    "status" => "error",
                    "message" => __( $error ),
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
