<?php 
if(!function_exists('twitter_refesh_token')){
    function twitter_refesh_token( $account_id, $accessToken )
    {
    	$client_id = get_team_data("twitter_client_id", "");
        $client_secret = get_team_data("twitter_client_secret", "");
        $consumer_key = get_team_data("twitter_consumer_key", "");
        $consumer_secret = get_team_data("twitter_consumer_secret", "");
        $bearer_token = get_team_data("twitter_bearer_token", "");

        if(!get_team_data("twitter_status", 0) || 
            $client_id == "" || 
            $client_secret == "" ||
            $consumer_key == "" ||
            $consumer_secret == "" ||
            $bearer_token == ""
        ){
            $client_id = get_option('twitter_client_id', '');
            $client_secret = get_option('twitter_client_secret', '');
            $consumer_key = get_option('twitter_consumer_key', '');
            $consumer_secret = get_option('twitter_consumer_secret', '');
            $bearer_token = get_option('twitter_bearer_token', '');
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://api.twitter.com/2/oauth2/token');
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(
            [
                'refresh_token' => $accessToken->refresh_token,
                'client_id' => $client_id,
                'grant_type' => 'refresh_token'                    
            ]
        ));

        $header = [
        	"Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
    		"Authorization: Basic ".base64_encode($client_id . ":" . $client_secret)
    	];

        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        $response = json_decode(curl_exec($curl), TRUE);

        if(isset($response['error'])){
            db_update(TB_ACCOUNTS, ["status" => 0], ["id" => $account_id]);
        }

        if(isset($response['access_token']) && isset($response['refresh_token'])){
            $accessToken->access_token = $response['access_token'];
            $accessToken->refresh_token = $response['refresh_token'];

            db_update(TB_ACCOUNTS, ["token" => json_encode($accessToken)], ["id" => $account_id]);
        }

        curl_close($curl);
        return $accessToken;

    }
}