<?php 
if(!function_exists('open_post_curl')){
    function open_post_curl($endpoint, $params)
    {
        $api_path =  "https://api.openai.com/v1/";
        $api_key = get_option("openai_api_key");

        if($api_key == ""){
            throw new Exception( __("Please configure Open API Key to use this feature.") , 1);
        }

        $url = $api_path . $endpoint;

        $ch = curl_init();
        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $api_key
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 180);
        curl_setopt($ch, CURLOPT_TIMEOUT, 180);
        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result);
    }
}

if(!function_exists('generate_text_bk')){
    function generate_text_bk($prompt, $max_lenght = 200, $number_of_results = 1, $limit_tokens = -1){
        $usage_tokens = get_team_data("openai_usage_tokens", 0);

        if($usage_tokens >= $limit_tokens && $limit_tokens != -1){
            throw new Exception( sprintf( __("You've used the reaching of the limit of %s OpenAI tokens"), $limit_tokens) , 1);
        }

        if($prompt == ""){
            throw new Exception( __("Prompt is required") , 1);
        }
        
        $result = open_post_curl("completions", [
            'model' => get_option("openai_default_model", "gpt-3.5-turbo"),
            'prompt' => trim($prompt),
            'max_tokens' => $max_lenght?$max_lenght:200,
            'n' => (int)$number_of_results
        ]);

        if($result == ""){
            throw new Exception( __("OpenAI connection timeout") , 1);
        }

        if( isset($result->error) ){
            throw new Exception( __($result->error->message) , 1);
        }

        $usage = $result->usage->total_tokens;

        update_team_data("openai_usage_tokens", get_team_data("openai_usage_tokens", 0) + $usage);

        return (object)[
            "status" => "success",
            "message" => __("Success"),
            "data" => $result
        ];
    }
}

if(!function_exists('generate_text')){
    function generate_text($messages, $max_lenght = 200, $number_of_results = 1, $limit_tokens = -1){

        /*if ( !get_option("openai_status", 0) || !permission("openai_content") || !permission("openai") ){
            throw new Exception( "You do not have sufficient permissions to use this feature. You need OpenAI permissions to use this feature." , 1);
        }*/

        $usage_tokens = get_team_data("openai_usage_tokens", 0);

        if($usage_tokens >= $limit_tokens && $limit_tokens != -1){
            throw new Exception( sprintf( __("You've used the reaching of the limit of %s OpenAI tokens"), $limit_tokens) , 1);
        }

        if($messages == ""){
            throw new Exception( __("Prompt is required") , 1);
        }

        $message_data = [];
        if(is_string($messages)){
            $message_data[] = [
                "role" => "user",
                "content" => $messages
            ];
        }else{
            $message_data = $message;
        }
        
        $result = open_post_curl("chat/completions", [
            'model' => get_option("openai_default_model", "gpt-3.5-turbo"),
            'messages' => $message_data,
            'max_tokens' => $max_lenght?$max_lenght:200,
            'n' => (int)$number_of_results
        ]);

        if($result == ""){
            throw new Exception( __("OpenAI connection timeout") , 1);
        }

        if( isset($result->error) ){
            throw new Exception( __($result->error->message) , 1);
        }

        $usage = $result->usage->total_tokens;

        update_team_data("openai_usage_tokens", get_team_data("openai_usage_tokens", 0) + $usage);

        return (object)[
            "status" => "success",
            "message" => __("Success"),
            "data" => $result
        ];
    }
}

if(!function_exists('generate_image')){
    function generate_image($suggestion, $size = "1024x1024", $qty = 1){

        /*if ( !get_option("openai_status", 0) || !permission("openai_image") || !permission("openai") ){
            throw new Exception( "You do not have sufficient permissions to use this feature. You need OpenAI permissions to use this feature." , 1);
        }*/

        if($suggestion == ""){
            throw new Exception( __("Suggestion is required") , 1);
        }

        if($size != "256x256" && $size != "512x512" && $size != "1024x1024"){
            throw new Exception( __("OpenAI just support size 256x256, 512x512, 1024x1024") , 1);
        }

        $result = open_post_curl("images/generations", [
            'prompt' => trim($suggestion),
            'n' => $qty,
            'size' => $size,
            "model" => get_option("openai_default_dalle_model", "dall-e-3")
        ]);

        if($result == ""){
            throw new Exception( __("OpenAI connection timeout") , 1);
        }

        if( isset($result->error) ){
            throw new Exception( __($result->error->message) , 1);
        }

        return (object)[
            "status" => "success",
            "message" => "Success",
            "data" => $result
        ];
    }
}

if (!function_exists("tone_of_voices")) {
    function tone_of_voices(){
        $tone_of_voices = [
            "Polite" => __("Polite"),
            "Witty" => __("Witty"),
            "Enthusiastic" => __("Enthusiastic"),
            "Friendly" => __("Friendly"),
            "Informational" => __("Informational"),
            "Funny" => __("Funny"),
            "Formal" => __("Formal"),
            "Informal" => __("Informal"),
            "Humorous" => __("Humorous"),
            "Serious" => __("Serious"),
            "Optimistic" => __("Optimistic"),
            "Motivating" => __("Motivating"),
            "Respectful" => __("Respectful"),
            "Assertive" => __("Assertive"),
            "Conversational" => __("Conversational"),
            "Casual" => __("Casual"),
            "Professional" => __("Professional"),
            "Smart" => __("Smart"),
            "Nostalgic" => __("Nostalgic")
        ];

        return $tone_of_voices;
    }
}

if (!function_exists("openai_creativity")) {
    function openai_creativity(){
        $creativity = [
            "0.25" => __("Economic"),
            "0.5" => __("Average"),
            "0.75" => __("Good"),
            "1" => __("Premium"),
        ];

        return $creativity;
    }
}

if (!function_exists("openai_models")) {
    function openai_models(){
        $models = [
            "text-davinci-003" => "Davinci (Pricy & Competent)",
            "gpt-3.5-turbo" => "ChatGPT (Highest Cost, Speediest, More capable)",
            "gpt-3.5-turbo-16k" => "ChatGTP (3.5-turbo-16k)",
            "gpt-4" => "ChatGPT-4 (Highest Cost, Speediest, More capable)",
            "gpt-4-1106-preview" => "GPT-4 Turbo (Knowledge refreshed up to April 2023, 128K context)",
            "gpt-4-vision-preview" => "Recognize images alongside the capabilities of GPT-4 Turbo"
        ];

        return $models;
    }
}