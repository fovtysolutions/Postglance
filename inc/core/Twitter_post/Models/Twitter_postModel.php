<?php
namespace Core\Twitter_post\Models;
use CodeIgniter\Model;
use Abraham\TwitterOAuth\TwitterOAuth;
use Twitter\Text\Parser;
use Coderjerk\BirdElephant\BirdElephant;
use Coderjerk\BirdElephant\Compose\Tweet;
use Coderjerk\BirdElephant\Compose\Media;

class Twitter_postModel extends Model
{
	public function __construct(){
        $this->config = include realpath( __DIR__."/../Config.php" );
        include get_module_dir( __DIR__ , 'Libraries/TwitterCookieApi.php');

        $this->client_id = get_team_data("twitter_client_id", "");
        $this->client_secret = get_team_data("twitter_client_secret", "");
        $this->consumer_key = get_team_data("twitter_consumer_key", "");
        $this->consumer_secret = get_team_data("twitter_consumer_secret", "");
        $this->bearer_token = get_team_data("twitter_bearer_token", "");

        if(!get_team_data("twitter_status", 0) || 
            $this->client_id == "" || 
            $this->client_secret == "" ||
            $this->consumer_key == "" ||
            $this->consumer_secret == "" ||
            $this->bearer_token == ""
        ){
            $this->client_id = get_option('twitter_client_id', '');
            $this->client_secret = get_option('twitter_client_secret', '');
            $this->consumer_key = get_option('twitter_consumer_key', '');
            $this->consumer_secret = get_option('twitter_consumer_secret', '');
            $this->bearer_token = get_option('twitter_bearer_token', '');
        }
        
        $this->credentials = array(
            'bearer_token' => $this->bearer_token,
            'consumer_key' => $this->consumer_key,
            'consumer_secret' => $this->consumer_secret,
            'auth_token' => '',
            'token_identifier' => '',
            'token_secret' => ''
        );
    }

    public function block_can_post(){
        return true;
    }

    public function block_plans(){
        return [
            "tab" => 10,
            "position" => 300,
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

    public function post_validator($post){
        $errors = array();
        $data = json_decode( $post->data , 1);
        $medias = $data['medias'];

        if($post->social_network == 'twitter'){
            $validator = Parser::create()->parseTweet($data["caption"]);
            if ($validator->weightedLength > 280) {
                $errors[] = __("Twitter just accept maximum post length is 280 characters.");
            }

            switch ($post->type) {
            
                case 'media':
                    if(!empty($data['medias'])){
                        if($post->api_type == 1){
                            if(!is_image($medias[0]))
                            {
                                //$errors[] = __("Currently, The system not supported post videos on Twitter");
                            }
                        }
                    }
                    break;
            }
            
        }

        return $errors;
    }

    public function block_frame_posts($path = ""){
        return [
            "position" => 300,
        	"preview" => view( 'Core\Twitter_post\Views\preview', [ 'config' => $this->config ] ),
        ];
    } 

    public function post_handler($post){
        $data = json_decode($post->data, false);
        $medias = $data->medias;
        $accessToken = json_decode($post->account->token);
        $endpoint = "statuses/update";
        $shortlink_by = shortlink_by($data);

        try
        {
            $caption = shortlink( spintax($data->caption), $shortlink_by );
            $link = shortlink( $data->link, $shortlink_by );
            switch ($post->account->login_type) {
                case 1:
                    $params = [];
                    $accessToken = twitter_refesh_token($post->account->id, $accessToken);
                    $this->credentials["auth_token"] = $accessToken->access_token;
                    $this->credentials["token_identifier"] = $accessToken->oauth_token;
                    $this->credentials["token_secret"] = $accessToken->oauth_token_secret;

                    $twitter = new BirdElephant($this->credentials);

                    switch ($post->type)
                    {
                        case 'media':
                            $media_ids = array();
                            $medias_chunk = array_chunk($medias, 4);
                            foreach ($medias_chunk[0] as $key => $media) {
                                $media = watermark($media, $post->team_id, $post->account_id);
                                $medias[$key] = $media;
                                $media == get_file_path($media);
                                if( stripos( strtolower($media) , "https://") !== false ||  stripos( strtolower($media) , "http://") !== false ){
                                    $media = save_img($media, TMPPATH());
                                }
                                $image_info = @getimagesize( get_file_path($media) );
                                if(!empty($image_info)){

                                    $upload = $twitter->tweets()->upload( get_file_path($media) );
                                    unlink_watermark([$media]);
                                    if( isset($upload->media_id_string)){
                                        $media_ids[] = $upload->media_id_string;
                                    }
                                    
                                }else{
                                    $connection = new TwitterOAuth($this->consumer_key, $this->consumer_secret, $accessToken->oauth_token, $accessToken->oauth_token_secret);
                                    $connection->setTimeouts(30,30);
                                    $upload = $connection->upload('media/upload', [
                                        'media' => get_file_path($media),
                                        'media_type' => 'video/mp4',
                                        'media_category' => 'tweet_video',
                                    ], true);

                                    $media_id = $upload->media_id_string;

                                    if(isset($upload->processing_info)) {
                                        $info = $upload->processing_info;
                                        if($info->state != 'succeeded') {
                                            $attempts = 0;
                                            $check_after_secs = $info->check_after_secs;
                                            $success = false;
                                            do {
                                                $attempts++;
                                                sleep($check_after_secs);
                                                $upload = $connection->mediaStatus($media_id);
                                                $processing_info = $upload->processing_info;
                                                if($processing_info->state == 'succeeded' || $processing_info->state == 'failed') {
                                                    break;
                                                }
                                                $check_after_secs = $processing_info->check_after_secs;
                                            } while($attempts <= 10);
                                        }
                                    }

                                    unlink_watermark([$media]);
                                    if( isset($upload->media_id_string)){
                                        $media_ids[] = $upload->media_id_string;
                                    }
                                }
                            }

                            $media_ids = (new Media)->mediaIds($media_ids);

                            $tweet = (new Tweet)->text($caption)
                                ->media($media_ids);

                            $response = $twitter->tweets()->tweet($tweet);

                            break;

                        case 'link':
                            $tweet = (new Tweet)->text($caption." ".$link);
                            $response = $twitter->tweets()->tweet($tweet);
                            break;

                        case 'text':

                            $tweet = (new Tweet)->text($caption." ".$link);
                            $response = $twitter->tweets()->tweet($tweet);
                            break;
                    }

                    if(isset($advance['location'])){
                        $params['place_id'] = (string)$advance['location'];
                    }

                    if(isset($response->data->id) && isset($response->data->id)){
                        return [
                            "status" => "success",
                            "message" => __('Success'),
                            "id" => $response->data->id,
                            "url" => "https://twitter.com/tweet/status/".$response->data->id,
                            "type" => $post->type
                        ]; 
                    }else{
                        return [
                            "status" => "error",
                            "message" => __( "Unknown error" ),
                            "type" => $post->type
                        ];
                    }
                    break;

                case 3:
                    if($post->account->tmp == ""){
                        return [
                            "status" => "error",
                            "message" => __( "You have not authorized your Twitter account yet. Please re-login and try again" ),
                            "type" => $post->type
                        ];
                    }

                    $accessToken = json_decode($post->account->tmp);
                    if( !is_array($accessToken) && (!isset($accessToken->twitter_csrf_token) || !isset($accessToken->twitter_auth_token) || !isset($accessToken->twitter_session)) ){
                        return [
                            "status" => "error",
                            "message" => __( "You have not authorized your Twitter account yet. Please re-login and try again" ),
                            "type" => $post->type
                        ];
                    }

                    $proxy = get_proxy($post->account->proxy);

                    if(!empty($medias)){
                        foreach ($medias as $key => $media) {
                            $media = watermark($media, $post->team_id, $post->account_id);
                            $medias[$key] = $media;
                        }
                    }

                    $tw_auth = new \TwitterCookieApi($accessToken->twitter_csrf_token, $accessToken->twitter_auth_token, $accessToken->twitter_session, $proxy);
                    $response = $tw_auth->createTweet($caption." ".$link, $medias);
                    if(is_string($response)){
                        return [
                            "status" => "error",
                            "message" => __($response),
                            "type" => $post->type
                        ];
                    }

                    return [
                        "status" => "success",
                        "message" => __('Success'),
                        "id" => $response->rest_id,
                        "url" => "https://twitter.com/tweet/status/".$response->rest_id,
                        "type" => $post->type
                    ]; 
                    break;
            }
        } catch(\Exception $e) {
            unlink_watermark($medias);
            return [
                "status" => "error",
                "message" => __( $e->getMessage() ),
                "type" => $post->type
            ];
        }
    }
}
