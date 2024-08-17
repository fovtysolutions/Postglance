<?php
/**
 * Class makes requests to Tinder API
 *
 * @author Stackcode
 */
if(!class_exists("TwitterAPI")){
    class TwitterAPI 
    {
        const GUEST_URL = 'https://api.twitter.com/1.1/guest/activate.json';
        const USER_INFO_URL = 'https://twitter.com/i/api/graphql/qRednkZG-rn1P6b48NINmQ/UserByScreenName?variables=%7B%22screen_name%22%3A%22{value}%22%2C%22withSafetyModeUserFields%22%3Atrue%7D&features=%7B%22hidden_profile_likes_enabled%22%3Afalse%2C%22responsive_web_graphql_exclude_directive_enabled%22%3Atrue%2C%22verified_phone_label_enabled%22%3Afalse%2C%22subscriptions_verification_info_verified_since_enabled%22%3Atrue%2C%22highlights_tweets_tab_ui_enabled%22%3Atrue%2C%22creator_subscriptions_tweet_preview_api_enabled%22%3Atrue%2C%22responsive_web_graphql_skip_user_profile_image_extensions_enabled%22%3Afalse%2C%22responsive_web_graphql_timeline_navigation_enabled%22%3Atrue%7D';
        const TIMELINE_URL = 'https://twitter.com/i/api/graphql/Uuw5X2n3tuGE_SatnXUqLA/UserTweets?variables=%7B%22userId%22%3A%22{value}%22%2C%22count%22%3A20%2C%22includePromotedContent%22%3Atrue%2C%22withQuickPromoteEligibilityTweetFields%22%3Atrue%2C%22withVoice%22%3Atrue%2C%22withV2Timeline%22%3Atrue%7D&features=%7B%22rweb_lists_timeline_redesign_enabled%22%3Atrue%2C%22responsive_web_graphql_exclude_directive_enabled%22%3Atrue%2C%22verified_phone_label_enabled%22%3Afalse%2C%22creator_subscriptions_tweet_preview_api_enabled%22%3Atrue%2C%22responsive_web_graphql_timeline_navigation_enabled%22%3Atrue%2C%22responsive_web_graphql_skip_user_profile_image_extensions_enabled%22%3Afalse%2C%22tweetypie_unmention_optimization_enabled%22%3Atrue%2C%22responsive_web_edit_tweet_api_enabled%22%3Atrue%2C%22graphql_is_translatable_rweb_tweet_is_translatable_enabled%22%3Atrue%2C%22view_counts_everywhere_api_enabled%22%3Atrue%2C%22longform_notetweets_consumption_enabled%22%3Atrue%2C%22tweet_awards_web_tipping_enabled%22%3Afalse%2C%22freedom_of_speech_not_reach_fetch_enabled%22%3Atrue%2C%22standardized_nudges_misinfo%22%3Atrue%2C%22tweet_with_visibility_results_prefer_gql_limited_actions_policy_enabled%22%3Afalse%2C%22longform_notetweets_rich_text_read_enabled%22%3Atrue%2C%22longform_notetweets_inline_media_enabled%22%3Atrue%2C%22responsive_web_enhance_cards_enabled%22%3Afalse%7D';
        
        const SEARCH_URL = 'https://twitter.com/i/api/graphql/GcjM7tlxA-EAM98COHsYwg/SearchTimeline?variables=%7B%22rawQuery%22%3A%22love%22%2C%22count%22%3A20%2C%22querySource%22%3A%22typed_query%22%2C%22product%22%3A%22Top%22%7D&features=%7B%22rweb_lists_timeline_redesign_enabled%22%3Atrue%2C%22responsive_web_graphql_exclude_directive_enabled%22%3Atrue%2C%22verified_phone_label_enabled%22%3Afalse%2C%22creator_subscriptions_tweet_preview_api_enabled%22%3Atrue%2C%22responsive_web_graphql_timeline_navigation_enabled%22%3Atrue%2C%22responsive_web_graphql_skip_user_profile_image_extensions_enabled%22%3Afalse%2C%22tweetypie_unmention_optimization_enabled%22%3Atrue%2C%22responsive_web_edit_tweet_api_enabled%22%3Atrue%2C%22graphql_is_translatable_rweb_tweet_is_translatable_enabled%22%3Atrue%2C%22view_counts_everywhere_api_enabled%22%3Atrue%2C%22longform_notetweets_consumption_enabled%22%3Atrue%2C%22tweet_awards_web_tipping_enabled%22%3Afalse%2C%22freedom_of_speech_not_reach_fetch_enabled%22%3Atrue%2C%22standardized_nudges_misinfo%22%3Atrue%2C%22tweet_with_visibility_results_prefer_gql_limited_actions_policy_enabled%22%3Afalse%2C%22longform_notetweets_rich_text_read_enabled%22%3Atrue%2C%22longform_notetweets_inline_media_enabled%22%3Atrue%2C%22responsive_web_enhance_cards_enabled%22%3Afalse%7D';

        public $bearer = 'Bearer AAAAAAAAAAAAAAAAAAAAANRILgAAAAAAnNwIzUejRCOuH5E6I8xnZz4puTs%3D1Zv7ttfk8LF81IUq16cHjhLTvJu4FA33AGWWjCpTnA';
        public $guest_token;

        public function __construct($id = "", $token = "") 
        {
            $this->guest_token = $this->get_guest_token();
        }

        public function get_guest_token()
        {
            $response = $this->call(self::GUEST_URL, "POST", $header = [
                'authorization: '.$this->bearer,
            ], );
            if(!$response) {
                throw new Exception('Could not get the guest token');
            }

            return $response->guest_token;
        }

        public function timeline($pid)
        {
            $response = $this->call(self::TIMELINE_URL, "GET", $header = [
                'host: twitter.com',
                'content-type: application/json',
                'authorization: '.$this->bearer,
                'x-guest-token: '.$this->guest_token,
                'connection: close'
            ], $pid);
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

        public function userinfo($username)
        {
            $response = $this->call(self::USER_INFO_URL, "GET", $header = [
                'host: twitter.com',
                'content-type: application/json',
                'authorization: '.$this->bearer,
                'x-guest-token: '.$this->guest_token,
                'connection: close'
            ], $username);
            if(!$response || !isset($response->data)) {
                throw new Exception('Could not get the user info');
            }

            return $response->data->user->result;
        }

        protected function call($enpoint, $method, $header, $value = "")
        {

            if($value != ""){
                $enpoint = str_replace("{value}", $value, $enpoint);
            }

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $enpoint);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HEADER, 0);

            if($method == "POST"){
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(
                    []
                ));
            }

            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
            $response = json_decode(curl_exec($curl));
            curl_close($curl);

            return $response;
        }
    }
}