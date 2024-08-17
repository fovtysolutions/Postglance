<?php
namespace Core\Google_business_profile_post\Models;
use CodeIgniter\Model;

class Google_business_profile_postModel extends Model
{
	public function __construct(){
        include get_module_dir( __DIR__ , 'Libraries/vendor/autoload.php');
        $this->config = include realpath( __DIR__."/../Config.php" );
        
        $client_id = get_option('gmb_client_id', '');
        $client_secret = get_option('gmb_api_secret', '');
        $api_key = get_option('gmb_api_key', '');

        $this->client = new \Google\Client();
        $this->client->setAccessType("offline");
        $this->client->setApprovalPrompt("force");
        $this->client->setApplicationName("GMB");
        $this->client->setClientId( $client_id );
        $this->client->setClientSecret( $client_secret );
        $this->client->setRedirectUri(get_module_url());
        $this->client->setDeveloperKey( $api_key );
        $this->client->setScopes(
            [
                'https://www.googleapis.com/auth/plus.business.manage',
                'https://www.googleapis.com/auth/business.manage',
                'https://www.googleapis.com/auth/userinfo.email'
            ]
        );
    }

    public function block_can_post(){
        return true;
    }

    public function block_plans(){
        return [
            "tab" => 10,
            "position" => 500,
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
            "position" => 500,
        	"preview" => view( 'Core\Google_business_profile_post\Views\preview', [ 'config' => $this->config ] ),
            "advance_options" => view( 'Core\Google_business_profile_post\Views\advance_options', [ 'config' => $this->config ] )
        ];
    }

    public function post_validator($post){
        $errors = array();
        $data = json_decode( $post->data , 1);
        $medias = $data['medias'];

        if($post->social_network == 'google_business_profile'){
            switch ($post->type) {
            
                case 'media':
                    if(empty($data['medias'])){
                        $errors[] = __("Google Business Profile requires an image");
                    }else{
                        if(!is_image($medias[0]))
                        {
                            $errors[] = __("Google Business Profile requires an image");
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
        $this->gmb = new \Google_Service_MyBusiness($this->client);

        try
        {
            $caption = shortlink( spintax($data->caption), $shortlink_by );
            $link = shortlink( $data->link, $shortlink_by );

            $gmb_posts = $this->gmb->accounts_locations_localPosts;
            $gmb_post = new \Google_Service_MyBusiness_LocalPost();
            $gmb_post->setLanguageCode("en");
            $gmb_post->setName($caption);
            $gmb_post->setSummary($caption);
            $gmb_post->setTopicType('STANDARD');

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

                    $medias[0] = watermark($medias[0], $post->team_id, $post->account->id);
                    unlink_watermark($medias);
                    $MediaItem = new \Google_Service_MyBusiness_MediaItem();
                    $MediaItem->setMediaFormat('PHOTO');
                    $MediaItem->setSourceUrl( get_file_url($medias[0]) );
                    $gmb_post->setMedia($MediaItem);
                    break;

                case 'link':
                    if( !empty($medias) && count($medias) != 0){
                        $medias[0] = watermark($medias[0], $post->team_id, $post->account->id);
                        $MediaItem = new \Google_Service_MyBusiness_MediaItem();
                        $MediaItem->setMediaFormat('PHOTO');
                        $MediaItem->setSourceUrl( get_file_url($medias[0]) );
                        $gmb_post->setMedia($MediaItem);
                    }else{
                        $gmb_post->setName($caption. " " . $link);
                        $gmb_post->setSummary($caption. " " . $link);
                    }
                    break;

                case 'text':
                    //Action Text
                    break;
            }

            if(
                isset( $data->advance_options ) &&
                isset( $data->advance_options->gmb_link ) &&
                isset( $data->advance_options->gmb_call ) &&
                $data->advance_options->gmb_link != "" &&
                $data->advance_options->gmb_call != ""
            ){
                $call = new \Google_Service_MyBusiness_CallToAction();
                $call->setActionType($data->advance_options->gmb_call);
                $call->setUrl( shortlink($data->advance_options->gmb_link, $shortlink_by) );
                $gmb_post->setCallToAction($call);
            }
            
            $response = $gmb_posts->create($post->account->username, $gmb_post);
            unlink_watermark($medias);

            return [
                "status" => "success",
                "message" => __('Success'),
                "id" => $response->getName(),
                "url" => $response->getSearchUrl(),
                "type" => $post->type
            ];
        } catch(\Exception $e) {
            $message = json_decode($e->getMessage());

            if(
                !empty($message) &&
                isset($message->error) && 
                isset($message->error->details[0]) && 
                isset($message->error->details[0]->errorDetails[0]) && 
                isset($message->error->details[0]->errorDetails[0]->message)

            ){
                $message = $message->error->details[0]->errorDetails[0]->message;
            }

            if(
                !empty($message) &&
                isset($message->error) && 
                isset($message->error->message)
            ){
                $message = $message->error->message;
            }

            if( empty($message) ){
                $message = __("Unknown error");
            }

            return [
                "status" => "error",
                "message" => __( $message ),
                "type" => $post->type
            ];
        }
    }
}
