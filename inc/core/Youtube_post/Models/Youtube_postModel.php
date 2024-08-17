<?php
namespace Core\Youtube_post\Models;
use CodeIgniter\Model;

class Youtube_postModel extends Model
{
	public function __construct(){
        $this->config = include realpath( __DIR__."/../Config.php" );
        
        $client_id = get_option('youtube_client_id', '');
        $client_secret = get_option('youtube_api_secret', '');
        $api_key = get_option('youtube_api_key', '');

        $this->client = new \Google\Client();
        $this->client->setAccessType("offline");
        $this->client->setApprovalPrompt("force");
        $this->client->setApplicationName("Youtube");
        $this->client->setClientId( $client_id );
        $this->client->setClientSecret( $client_secret );
        $this->client->setRedirectUri(get_module_url());
        $this->client->setDeveloperKey( $api_key );
        $this->client->setScopes(
            [
                'https://www.googleapis.com/auth/youtube', 
                'https://www.googleapis.com/auth/userinfo.email'
            ]
        );

        $this->youtube = new \Google\Service\YouTube($this->client);
    }

    public function block_can_post(){
        return true;
    }

    public function block_plans(){
        return [
            "tab" => 10,
            "position" => 400,
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
            "position" => 400,
        	"preview" => view( 'Core\Youtube_post\Views\preview', [ 'config' => $this->config ] ),
            "advance_options" => view( 'Core\Youtube_post\Views\advance_options', [ 'config' => $this->config ] )
        ];
    }

    public function post_validator($post){
        $errors = array();
        $data = json_decode( $post->data , 1);
        $medias = $data['medias'];

        if($post->social_network == 'youtube'){
            if( !isset( $data['advance_options'] ) || !isset( $data['advance_options']['youtube_title'] ) ||  $data['advance_options']['youtube_title'] == ""){
                $errors[] = __("A title for the post on Youtube is mandatory");
            }

            switch ($post->type) {

                case 'text':
                    $errors[] = __("Youtube does not support posting as text");
                    break;

                case 'link':
                    $errors[] = __("Youtube does not support posting as link");
                    break;
                
                case 'media':
                    if(empty($data['medias'])){
                        $errors[] = __("Youtube just support posting as video");
                    }else{
                        if(!is_video($medias[0]))
                        {
                            $errors[] = __("Youtube just support posting as video");
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

        $this->client->setAccessToken($post->account->token);

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

                    if(!is_video($medias[0]))
                    {
                        return [
                            "status" => "error",
                            "message" => __("Cannot find the video to upload"),
                            "type" => $post->type
                        ];
                    }
 
                    $videoPath = get_file_path($medias[0]);
                    $caption = shortlink( spintax($data->caption), $shortlink_by);
                    if( isset( $data->advance_options ) && isset( $data->advance_options->youtube_title ) && $data->advance_options->youtube_title != ""){
                        $title = spintax($data->advance_options->youtube_title);
                    }else{
                        $title = $caption;
                    }

                    $snippet = new \Google_Service_YouTube_VideoSnippet();
                    $snippet->setTitle($title);
                    $snippet->setDescription($caption);

                    if( isset( $data->advance_options ) && isset( $data->advance_options->youtube_title ) && $data->advance_options->youtube_tags != ""){
                        $tags = explode(",", $data->advance_options->youtube_tags);
                        $snippet->setTags($tags);
                    }

                    if( isset( $data->advance_options ) && isset( $data->advance_options->youtube_title ) && $data->advance_options->youtube_category != ""){
                        $snippet->setCategoryId($data->advance_options->youtube_category);
                    }

                    $status = new \Google_Service_YouTube_VideoStatus();
                    $status->privacyStatus = "public";

                    $video = new \Google_Service_YouTube_Video();
                    $video->setSnippet($snippet);
                    $video->setStatus($status);

                    $chunkSizeBytes = 1 * 1024 * 1024;
                   
                    $this->client->setDefer(true);
                    $insertRequest = $this->youtube->videos->insert("status,snippet", $video);
                    $media = new \Google_Http_MediaFileUpload(
                        $this->client,
                        $insertRequest,
                        'video/*',
                        null,
                        true,
                        $chunkSizeBytes
                    );
                    $media->setFileSize(filesize($videoPath));

                    // Read the media file and upload it chunk by chunk.
                    $status = false;
                    $handle = fopen($videoPath, "rb");
                    while (!$status && !feof($handle)) {
                      $chunk = fread($handle, $chunkSizeBytes);
                      $status = $media->nextChunk($chunk);
                    }

                    fclose($handle);

                    $this->client->setDefer(false);

                    $response = $status;

                    return [
                        "status" => "success",
                        "message" => __('Success'),
                        "id" => $response->getId(),
                        "url" => "https://www.youtube.com/watch?v=".$response->getId(),
                        "type" => $post->type
                    ]; 

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
