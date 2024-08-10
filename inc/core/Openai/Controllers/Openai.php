<?php
namespace Core\Openai\Controllers;

class Openai extends \CodeIgniter\Controller
{
    public function __construct(){
        $this->config = parse_config( include realpath( __DIR__."/../Config.php" ) );
    }

    public function widget( $params = [] ){
        return view('Core\Openai\Views\widget', ['config' => $this->config, "name" => $params["name"]]);
    }

    public function image_widget( $params = [] ){
        return view('Core\Openai\Views\image_widget', ['config' => $this->config]);
    }

    public function popup($name = ""){
        return view('Core\Openai\Views\popup', ['config' => $this->config, "name" => $name]);
    }

    public function image_popup(){
        return view('Core\Openai\Views\image_popup', ['config' => $this->config]);
    }

    public function generate(){
        try {
            $prompt_keyword = post("suggestion");
            $maximum_length = (int)post("max_length");
            $hashtags = (int)post("hashtags");
            $tone_of_voice = post("tone_of_voice");
            $language = post("language");
            $creativity = post("creativity");
            $limit_tokens = (int)permission("openai_limit_tokens");
            $usage_tokens = get_team_data("openai_usage_tokens", 0);

            if($hashtags){
                $prompt = "Create a paragraph about {$prompt_keyword} with $hashtags hashtags at the end of paragraph. Maximum $maximum_length words. Creativity is $creativity between 0 and 1. Language is $language. Tone of voice must be $tone_of_voice.";
            }else{
                $prompt = "Create a paragraph about {$prompt_keyword}. Maximum $maximum_length words. Creativity is $creativity between 0 and 1. Language is $language. Tone of voice must be $tone_of_voice.";
            }
            
            $text_result = generate_text($prompt, $maximum_length);

            $caption = $text_result->data->choices[0]->message->content;
            $caption = trim($caption, '"');
            $caption = ltrim($caption, '"');

            ms([
                "status" => "success",
                "message" => "Success",
                "data" => trim($caption)
            ]);
        } catch (\Exception $e) {
            ms([
                "status" => "error",
                "message" => $e->getMessage(),
            ]);
        }
    }

    public function generate_image(){
        try {
            $prompt_keyword = post("suggestion");
            $image_result = generate_image($prompt_keyword);

            ms([
                "status" => "success",
                "message" => "Success",
                "data" => $image_result->data->data[0]->url
            ]);
         } catch (\Exception $e) {
            ms([
                "status" => "error",
                "message" => $e->getMessage(),
            ]);
        } 
    }
}