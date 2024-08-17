<?php
/**
 * Class makes requests to Tinder API
 *
 * @author Stackcode
 */
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Psr7\MultipartStream;
if(!class_exists("TwitterCookieApi")){
    include "Curl.php";

    class TwitterCookieApi 
    {
        const UPLOAD_URL = 'https://upload.twitter.com/i/media/upload.json?';
        const CREATE_TWEET = 'https://twitter.com/i/api/graphql/BN7FYuBiFfIcD_D76Zea_Q/CreateTweet';
        const GUEST_URL = 'https://api.twitter.com/1.1/guest/activate.json';
        const SETTINGS_URL = 'https://twitter.com/i/api/2/notifications/all.json?include_profile_interstitial_type=1&include_blocking=1&include_blocked_by=1&include_followed_by=1&include_want_retweets=1&include_mute_edge=1&include_can_dm=1&include_can_media_tag=1&include_ext_has_nft_avatar=1&include_ext_is_blue_verified=1&include_ext_verified_type=1&include_ext_profile_image_shape=1&skip_status=1&cards_platform=Web-12&include_cards=1&include_ext_alt_text=true&include_ext_limited_action_results=true&include_quote_count=true&include_reply_count=1&tweet_mode=extended&include_ext_views=true&include_entities=true&include_user_entities=true&include_ext_media_color=true&include_ext_media_availability=true&include_ext_sensitive_media_warning=true&include_ext_trusted_friends_metadata=true&send_error_codes=true&simple_quoted_tweet=true&count=20&requestContext=launch&ext=mediaStats%2ChighlightedLabel%2ChasNftAvatar%2CvoiceInfo%2CbirdwatchPivot%2CsuperFollowMetadata%2CunmentionInfo%2CeditControl';
        const USER_INFO_URL = 'https://twitter.com/i/api/graphql/oUZZZ8Oddwxs8Cd3iW3UEA/UserByScreenName?variables=%7B%22screen_name%22%3A%22{value}%22%2C%22withSafetyModeUserFields%22%3Atrue%7D&features=%7B%22hidden_profile_likes_enabled%22%3Afalse%2C%22responsive_web_graphql_exclude_directive_enabled%22%3Atrue%2C%22verified_phone_label_enabled%22%3Afalse%2C%22subscriptions_verification_info_verified_since_enabled%22%3Atrue%2C%22highlights_tweets_tab_ui_enabled%22%3Atrue%2C%22creator_subscriptions_tweet_preview_api_enabled%22%3Atrue%2C%22responsive_web_graphql_skip_user_profile_image_extensions_enabled%22%3Afalse%2C%22responsive_web_graphql_timeline_navigation_enabled%22%3Atrue%7D';
        const TIMELINE_URL = 'https://twitter.com/i/api/graphql/VgitpdpNZ-RUIp5D1Z_D-A/UserTweets?variables=%7B%22userId%22%3A%22{value}%22%2C%22count%22%3A20%2C%22includePromotedContent%22%3Atrue%2C%22withQuickPromoteEligibilityTweetFields%22%3Atrue%2C%22withVoice%22%3Atrue%2C%22withV2Timeline%22%3Atrue%7D&features=%7B%22responsive_web_graphql_exclude_directive_enabled%22%3Atrue%2C%22verified_phone_label_enabled%22%3Afalse%2C%22responsive_web_home_pinned_timelines_enabled%22%3Atrue%2C%22creator_subscriptions_tweet_preview_api_enabled%22%3Atrue%2C%22responsive_web_graphql_timeline_navigation_enabled%22%3Atrue%2C%22responsive_web_graphql_skip_user_profile_image_extensions_enabled%22%3Afalse%2C%22c9s_tweet_anatomy_moderator_badge_enabled%22%3Atrue%2C%22tweetypie_unmention_optimization_enabled%22%3Atrue%2C%22responsive_web_edit_tweet_api_enabled%22%3Atrue%2C%22graphql_is_translatable_rweb_tweet_is_translatable_enabled%22%3Atrue%2C%22view_counts_everywhere_api_enabled%22%3Atrue%2C%22longform_notetweets_consumption_enabled%22%3Atrue%2C%22responsive_web_twitter_article_tweet_consumption_enabled%22%3Afalse%2C%22tweet_awards_web_tipping_enabled%22%3Afalse%2C%22freedom_of_speech_not_reach_fetch_enabled%22%3Atrue%2C%22standardized_nudges_misinfo%22%3Atrue%2C%22tweet_with_visibility_results_prefer_gql_limited_actions_policy_enabled%22%3Atrue%2C%22longform_notetweets_rich_text_read_enabled%22%3Atrue%2C%22longform_notetweets_inline_media_enabled%22%3Atrue%2C%22responsive_web_media_download_video_enabled%22%3Afalse%2C%22responsive_web_enhance_cards_enabled%22%3Afalse%7D';
        
        const SEARCH_URL = 'https://twitter.com/i/api/graphql/GcjM7tlxA-EAM98COHsYwg/SearchTimeline?variables=%7B%22rawQuery%22%3A%22love%22%2C%22count%22%3A20%2C%22querySource%22%3A%22typed_query%22%2C%22product%22%3A%22Top%22%7D&features=%7B%22rweb_lists_timeline_redesign_enabled%22%3Atrue%2C%22responsive_web_graphql_exclude_directive_enabled%22%3Atrue%2C%22verified_phone_label_enabled%22%3Afalse%2C%22creator_subscriptions_tweet_preview_api_enabled%22%3Atrue%2C%22responsive_web_graphql_timeline_navigation_enabled%22%3Atrue%2C%22responsive_web_graphql_skip_user_profile_image_extensions_enabled%22%3Afalse%2C%22tweetypie_unmention_optimization_enabled%22%3Atrue%2C%22responsive_web_edit_tweet_api_enabled%22%3Atrue%2C%22graphql_is_translatable_rweb_tweet_is_translatable_enabled%22%3Atrue%2C%22view_counts_everywhere_api_enabled%22%3Atrue%2C%22longform_notetweets_consumption_enabled%22%3Atrue%2C%22tweet_awards_web_tipping_enabled%22%3Afalse%2C%22freedom_of_speech_not_reach_fetch_enabled%22%3Atrue%2C%22standardized_nudges_misinfo%22%3Atrue%2C%22tweet_with_visibility_results_prefer_gql_limited_actions_policy_enabled%22%3Afalse%2C%22longform_notetweets_rich_text_read_enabled%22%3Atrue%2C%22longform_notetweets_inline_media_enabled%22%3Atrue%2C%22responsive_web_enhance_cards_enabled%22%3Afalse%7D';

        const PROFILE_URL = 'https://twitter.com/i/api/graphql/NimuplG1OB7Fd2btCLdBOw/UserByScreenName?variables=%7B%22screen_name%22%3A%22{value}%22%2C%22withSafetyModeUserFields%22%3Atrue%7D&features=%7B%22hidden_profile_likes_enabled%22%3Atrue%2C%22hidden_profile_subscriptions_enabled%22%3Atrue%2C%22responsive_web_graphql_exclude_directive_enabled%22%3Atrue%2C%22verified_phone_label_enabled%22%3Afalse%2C%22subscriptions_verification_info_is_identity_verified_enabled%22%3Atrue%2C%22subscriptions_verification_info_verified_since_enabled%22%3Atrue%2C%22highlights_tweets_tab_ui_enabled%22%3Atrue%2C%22responsive_web_twitter_article_notes_tab_enabled%22%3Afalse%2C%22creator_subscriptions_tweet_preview_api_enabled%22%3Atrue%2C%22responsive_web_graphql_skip_user_profile_image_extensions_enabled%22%3Afalse%2C%22responsive_web_graphql_timeline_navigation_enabled%22%3Atrue%7D&fieldToggles=%7B%22withAuxiliaryUserLabels%22%3Afalse%7D';


        const SETTINGS_DATA_URL = 'https://api.twitter.com/1.1/account/settings.json?include_mention_filter=true&include_nsfw_user_flag=true&include_nsfw_admin_flag=true&include_ranked_timeline=true&include_alt_text_compose=true&ext=ssoConnections&include_country_code=true&include_ext_dm_nsfw_media_filter=true&include_ext_sharing_audiospaces_listening_data_with_followers=true';
        

        private $client;
        private $twCsrfToken;
        private $twAuthToken;
        private $twSession;
        private $proxy;

        public function __construct ( $twCsrfToken, $twAuthToken, $twSession, $proxy = NULL)
        {

            $this->twCsrfToken  = $twCsrfToken;
            $this->twAuthToken  = $twAuthToken;
            $this->twSession    = $twSession;
            $this->proxy        = $proxy;

            $this->client = new Client( [
                'cookies'         => $this->buildCookies(),
                'allow_redirects' => [ 'max' => 5 ],
                'proxy'           => empty( $proxy ) ? NULL : $proxy,
                'verify'          => FALSE,
                'http_errors'     => FALSE,
                'headers'         => [ 'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:66.0) Gecko/20100101 Firefox/66.0' ]
            ] );
        }

        private function buildHeaders ( $additionalHeaders = [] )
        {
            $headers = [
                'host' => 'twitter.com',
                'content-type' => 'application/json',
                'authorization' => 'Bearer AAAAAAAAAAAAAAAAAAAAANRILgAAAAAAnNwIzUejRCOuH5E6I8xnZz4puTs%3D1Zv7ttfk8LF81IUq16cHjhLTvJu4FA33AGWWjCpTnA',
                'connection' => 'close',
            ];

            return array_merge( $headers, $additionalHeaders );
        }

        private function buildCookies ()
        {
            $cookies = [
                'ct0'           => $this->twCsrfToken,
                'auth_token'    => $this->twAuthToken,
                '_twitter_sess' => $this->twSession
            ];

            $cooks = [];

            foreach ( $cookies as $k => $v )
            {
                $cooks[] = [
                    "Name"     => $k,
                    "Value"    => $v,
                    "Domain"   => ".twitter.com",
                    "Path"     => "/",
                    "Max-Age"  => NULL,
                    "Expires"  => NULL,
                    "Secure"   => FALSE,
                    "Discard"  => FALSE,
                    "HttpOnly" => FALSE,
                    "Priority" => "HIGH"
                ];
            }

            return new CookieJar( FALSE, $cooks );
        }

        public function myInfo ()
        {
            try
            {
                $req = $this->client->request( 'GET', self::SETTINGS_DATA_URL, [
                    'headers' => $this->buildHeaders([
                        'authority' => 'api.twitter.com',
                        'X-Csrf-Token'  => $this->twCsrfToken,
                        'origin' => 'https://twitter.com',
                        'referer' => 'https://twitter.com/',
                        'Accept' => '*/*',
                        'host' => 'api.twitter.com'
                    ])
                ] );

                $settings_info = (string) $req->getBody();
                $settings_info = json_decode($settings_info);

                if(!$settings_info || !isset($settings_info->screen_name)) {
                    throw new Exception('Could not get the user info');
                }

                $enpoint = self::PROFILE_URL;
                $enpoint = str_replace("{value}", $settings_info->screen_name, $enpoint);

                $req = $this->client->request( 'GET', $enpoint, [
                    'headers' => $this->buildHeaders([
                        'X-Csrf-Token'  => $this->twCsrfToken,
                    ])
                ] );

                $response = (string) $req->getBody();
                $response = json_decode($response);

            }
            catch ( Exception $e )
            {
                throw new Exception( __( $e->getMessage() ) );
            }

            if(!$response || !isset($response->data)) {
                throw new Exception('Could not get the user info');
            }

            return $response->data->user->result;
        }

        public function getTimeline($pid = "")
        {
            try
            {
                $enpoint = self::TIMELINE_URL;

                if($pid != ""){
                    $enpoint = str_replace("{value}", $pid, $enpoint);
                }

                $req = $this->client->request( 'GET', $enpoint, [
                    'headers' => $this->buildHeaders([
                        'X-Csrf-Token'  => $this->twCsrfToken,
                    ])
                ] );

                $response = (string) $req->getBody();
                $response = json_decode($response);
            }
            catch ( Exception $e )
            {
                throw new Exception( __( $e->getMessage() ) );
            }

            if(!$response || !isset($response->data)) {
                throw new Exception('Could not get the timeline');
            }

            $tweets = [];
            $entries = $response->data->user->result->timeline_v2->timeline->instructions[1]->entries;

            if(!empty($entries)){
                foreach ($entries as $key => $value) {
                    if(isset($value->content->itemContent)){
                        if(isset($value->content->itemContent->tweet_results->result->legacy->extended_entities)){
                            $tweets[] = $value->content->itemContent->tweet_results->result->legacy;
                        }else{
                            $tweets[] = $value->content->itemContent->tweet_results->result->legacy;
                        }
                    }
                }
            }

            return $tweets;
        }

        public function createTweet($caption, $medias = []){
            $media_ids = [];
            if(!empty($medias)){
                foreach ($medias as $media) {
                    if (stripos($media, "https://") === false && stripos($media, "http://") === false) {
                        $media = get_file_path($media);
                    }

                    $chunked = false;
                    if(!is_image($media)){
                        $chunked = true;
                    }

                    $media_id = $this->uploadMedia( $media, $chunked );

                    if($media_id){
                        $media_ids[] = [ "media_id" => $media_id, "tagged_users" => [] ];
                    }
                }
            }

            $variables = [
                'tweet_text' => $caption,
                'dark_request' => false,
                'media' => [
                    'media_entities' => $media_ids,
                    'possibly_sensitive' => false,
                ],
                'semantic_annotation_ids' => [],
            ];

            $sendData = $this->buildSendData( $variables );
            $sendData = json_encode($sendData);

            $post = (string) $this->client->post( self::CREATE_TWEET, [
                'headers' => $this->buildHeaders( [
                    'X-Csrf-Token'  => $this->twCsrfToken,
                    'Content-Type' => 'application/json',
                    'Content-Length'     => strlen( $sendData ),
                ] ),
                'body'    => $sendData
            ] )->getBody();

            if(empty($post)){
                return __("Post failed");
            }

            $post = json_decode($post);

            if(isset($post->errors)){
                return __($post->errors[0]->message);
            }

            return $post->data->create_tweet->tweet_results->result;
        }

        private function uploadMedia($media, $chunked = false){
            try {
                $fileinfo = get_header($media);

                if(empty($fileinfo) || !isset($fileinfo['content-length']) || !isset($fileinfo['content-type'])){
                    $fileinfo = false;
                }
            } catch (\Exception $e) {
                $fileinfo = false;
            }

            if(!$fileinfo){
                $total_bytes = filesize($media);
                $media_type = mime_content_type ($media);
            }else{
                $total_bytes = $fileinfo['content-length'];
                $media_type = $fileinfo['content-type'];
            }

            $tweet_type = "tweet_image";
            if(!is_image($media)){
                $tweet_type = "tweet_video";
            }

            $basename = basename( $media );
            if ( strpos( $basename, '.' ) === FALSE )
            {
                $basename = $basename . '.jpg';
            }

            if($fileinfo){
                if ( strpos( $basename, '.' ) === FALSE )
                {
                    $img = file_get_contents( $media );
                }
                else
                {
                    $img = Curl::getURL( $media, $this->proxy );
                }

                if(empty($img)) return false;
            }else{
                $img = fopen($media, 'rb');
            }

            try
            {
                /*
                * INIT UPLOAD
                */
                $init_query = [
                    'command' => 'INIT',
                    'total_bytes' => $total_bytes,
                    'media_type' => $media_type,
                    'media_category' => $tweet_type,
                ];

                $upload_init = $this->client->post( self::UPLOAD_URL.http_build_query($init_query), [
                    'headers' => $this->buildHeaders([
                        'authority' => 'upload.twitter.com',
                        'X-Csrf-Token'  => $this->twCsrfToken,
                        'origin' => 'https://twitter.com',
                        'referer' => 'https://twitter.com/'
                    ])
                ] )->getBody()->getContents();

                if(empty($upload_init)) return false;

                $upload_init = json_decode($upload_init);

                if(!isset($upload_init->media_id)) return false;

                if(!$chunked){
                    /*
                    * APPEND UPLOAD
                    */
                    $append_query = [
                        'command' => 'APPEND',
                        'media_id' => $upload_init->media_id,
                        'segment_index' => 0
                    ];

                    $postData = [
                        [
                            'name'  => 'media',
                            'contents' => $img,
                            'filename' => $basename
                        ]
                    ];

                    $body = new MultipartStream(
                        $postData,
                        '----WebKitFormBoundarysCx4OQIbodbojNXL'
                    );

                    $upload_append = $this->client->post( self::UPLOAD_URL.http_build_query($append_query), [
                        'body' => $body,
                        'headers' => $this->buildHeaders([
                            'authority'         => 'upload.twitter.com',
                            'X-Csrf-Token'      => $this->twCsrfToken,
                            'Origin'            => 'https://twitter.com',
                            'referer'           => 'https://twitter.com/',
                            'content-length'    => strlen( $body ),
                            'content-type'      => 'multipart/form-data; boundary=----WebKitFormBoundarysCx4OQIbodbojNXL',
                        ])
                    ] )->getBody()->getContents();


                    if(!empty($upload_append)) return false;

                    /*
                    * FINALIZE UPLOAD
                    */
                    $upload_finalize = [];
                    $attempts = 0;
                    $check_after_secs = 3;
                    $success = false;
                    do {
                        $attempts++;
                        sleep($check_after_secs);

                        $finalize_query = [
                            'command' => 'FINALIZE',
                            'media_id' => $upload_init->media_id
                        ];

                        $upload_finalize = $this->client->post( self::UPLOAD_URL.http_build_query($finalize_query), [
                            'headers' => $this->buildHeaders([
                                'authority' => 'upload.twitter.com',
                                'X-Csrf-Token'  => $this->twCsrfToken,
                                'origin' => 'https://twitter.com',
                                'referer' => 'https://twitter.com/'
                            ])
                        ] )->getBody()->getContents();

                        if(!empty($upload_finalize)){
                            $upload_finalize = json_decode($upload_finalize);
                            if(isset($upload_finalize->media_id)){
                                break;
                            }
                        }
                    } while($attempts <= 10);
                }else{
                    $chunkSize = 1048576;
                    $segmentIndex = 0;
                    $media_open = fopen($media, 'rb');

                    while (!feof($media_open)) {

                        $append_query = [
                            'command' => 'APPEND',
                            'media_id' => $upload_init->media_id,
                            'segment_index' => $segmentIndex
                        ];

                        $postData = [
                            [
                                'name'  => 'media',
                                'contents' => fread($media_open, $chunkSize),
                                'filename' => $basename
                            ]
                        ];

                        $body = new MultipartStream(
                            $postData,
                            '----WebKitFormBoundarysCx4OQIbodbojNXL'
                        );

                        $upload_append = $this->client->post( self::UPLOAD_URL.http_build_query($append_query), [
                            'body' => $body,
                            'headers' => $this->buildHeaders([
                                'authority'         => 'upload.twitter.com',
                                'X-Csrf-Token'      => $this->twCsrfToken,
                                'origin'            => 'https://twitter.com',
                                'referer'           => 'https://twitter.com/',
                                'content-length'    => strlen( $body ),
                                'content-type'      => 'multipart/form-data; boundary=----WebKitFormBoundarysCx4OQIbodbojNXL',
                            ])
                        ] )->getBody()->getContents();
                        if(!empty($upload_append)) return false;

                        $segmentIndex++;
                    }
                    fclose($media_open);

                    /*
                    * FINALIZE UPLOAD
                    */
                    $finalize_query_tmp = [
                        'command' => 'FINALIZE',
                        'media_id' => $upload_init->media_id,
                        'allow_async' => true
                    ];

                    $upload_finalize_tmp = $this->client->post( self::UPLOAD_URL.http_build_query($finalize_query_tmp), [
                        'headers' => $this->buildHeaders([
                            'authority' => 'upload.twitter.com',
                            'X-Csrf-Token'  => $this->twCsrfToken,
                            'origin' => 'https://twitter.com',
                            'referer' => 'https://twitter.com/'
                        ])
                    ] )->getBody()->getContents();

                    /*
                    * STATUS UPLOAD
                    */
                    $upload_finalize = [];
                    $attempts = 0;
                    $check_after_secs = 3;
                    $success = false;

                    do {
                        $attempts++;
                        sleep($check_after_secs);

                        $finalize_query = [
                            'command' => 'STATUS',
                            'media_id' => $upload_init->media_id
                        ];

                        $upload_finalize = $this->client->get( self::UPLOAD_URL.http_build_query($finalize_query), [
                            'headers' => $this->buildHeaders([
                                'authority' => 'upload.twitter.com',
                                'X-Csrf-Token'  => $this->twCsrfToken,
                                'origin' => 'https://twitter.com',
                                'referer' => 'https://twitter.com/'
                            ])
                        ] )->getBody()->getContents();

                        if(!empty($upload_finalize)){
                            $upload_finalize = json_decode($upload_finalize);
                            $processing_info = $upload_finalize->processing_info;
                            if($processing_info->state == 'succeeded' || $processing_info->state == 'failed') {
                                break;
                            }
                            $check_after_secs = $processing_info->check_after_secs;
                        }else{
                            $check_after_secs = 3;
                        }
                    } while($attempts <= 20);
                }
            }
            catch ( \Exception $e )
            {
                $upload_finalize = '';
            }

            return isset( $upload_finalize->media_id ) ? $upload_finalize->media_id : 0;
        }

        private function buildSendData ( $variables = [] )
        {
            $sendData = [
                'fieldToggles' => json_encode(['withArticleRichContentState' => false]),
                'features' => json_encode([
                    'tweetypie_unmention_optimization_enabled' => true,
                    'responsive_web_edit_tweet_api_enabled' => true,
                    'graphql_is_translatable_rweb_tweet_is_translatable_enabled' => true,
                    'view_counts_everywhere_api_enabled' => true,
                    'longform_notetweets_consumption_enabled' => true,
                    'responsive_web_twitter_article_tweet_consumption_enabled' => false,
                    'tweet_awards_web_tipping_enabled' => false,
                    'longform_notetweets_rich_text_read_enabled' => true,
                    'longform_notetweets_inline_media_enabled' => true,
                    'responsive_web_graphql_exclude_directive_enabled' => true,
                    'verified_phone_label_enabled' => false,
                    'freedom_of_speech_not_reach_fetch_enabled' => true,
                    'standardized_nudges_misinfo' => true,
                    'tweet_with_visibility_results_prefer_gql_limited_actions_policy_enabled' => true,
                    'responsive_web_media_download_video_enabled' => false,
                    'responsive_web_graphql_skip_user_profile_image_extensions_enabled' => false,
                    'responsive_web_graphql_timeline_navigation_enabled' => true,
                    'responsive_web_enhance_cards_enabled' => false,
                ]),
                'queryId' => "BN7FYuBiFfIcD_D76Zea_Q"
            ];

            if ( ! empty( $variables ) )
            {
                $sendData[ 'variables' ] = json_encode( $variables );
            }

            return $sendData;
        }
    }
}