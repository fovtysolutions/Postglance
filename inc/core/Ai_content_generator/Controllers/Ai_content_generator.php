<?php
namespace Core\Ai_content_generator\Controllers;

class Ai_content_generator extends \CodeIgniter\Controller
{
    public function __construct(){
        $this->config = parse_config( include realpath( __DIR__."/../Config.php" ) );
        $this->class_name = get_class_name($this);
        $this->model = new \Core\Ai_content_generator\Models\Ai_content_generatorModel();
    }
    
    public function index( $page = false ) {
        $team_id = get_team("id");
        $data = [
            "title" => $this->config['menu']['name'],
            "desc" => $this->config['desc'],
            "config"  => $this->config,
        ];

        // $result = db_fetch("*", TB_AI_PROMPT_CATEGORIES, ["status" => 1], "created", "ASC");
        // $templates = db_fetch("*", TB_AI_PROMPT_TEMPLATES, ["status" => 1], "created", "ASC");
        $templates = '';
        $result = '';

        $data_content = [
            "result" => $result,
            "templates" => $templates,
            "config"  => $this->config,
        ];

        $data['content'] = view('Core\Ai_content_generator\Views\content', $data_content);

        return view('Core\Ai_content_generator\Views\index', $data);
    }

    public function generate(){
        try {
            $prompt_keyword = post("prompt");
            $maximum_length = (int)post("maximum_length");
            $hashtags = (int)post("hashtags");
            $tone_of_voice = post("tone_of_voice");
            $language = post("language");
            $creativity = post("creativity");
            $n = post("n");
            $limit_tokens = (int)permission("openai_limit_tokens");
            $usage_tokens = get_team_data("openai_usage_tokens", 0);
            $max_input_lenght = (int)get_option("openai_default_max_input_lenght", "1000");

            if($n < 1 || $n > 10){
                $n = 3;
            }

            if($prompt_keyword == ""){
                ms([
                    "status" => "error",
                    "message" => "Please enter your prompt"
                ]);
            }

            if($hashtags){
                $prompt = "Create a paragraph about {$prompt_keyword} with $hashtags hashtags at the end of paragraph. Maximum $maximum_length words. Creativity is $creativity between 0 and 1. Language is $language. Tone of voice must be $tone_of_voice.";
            }else{
                $prompt = "Create a paragraph about {$prompt_keyword}. Maximum $maximum_length words. Creativity is $creativity between 0 and 1. Language is $language. Tone of voice must be $tone_of_voice.";
            }

            $result = generate_text($prompt, $max_input_lenght, $n);
            $data = [ 'result' => $result ];
            return view('Core\Ai_content_generator\Views\result', $data);
        } catch (\Exception $e) {
            ms([
                "status" => "error",
                "message" => $e->getMessage(),
            ]);
        }
    }

    public function block( $params = [] ){
        $data = [
            'name' => isset($params['name'])?$params['name']:"Ai_content_generator",
            'value' => isset($params['value'])?$params['value']:"",
            'placeholder' => isset($params['placeholder'])?$params['placeholder']:__("Write a Ai_content_generator"),
        ];
        return view('Core\Ai_content_generator\Views\block', $data);
    }

    public function widget( $params = [] ){
        return view('Core\Ai_content_generator\Views\widget', ['config' => $this->config, "name" => $params["name"]]);
    }

    public function popup($name = ""){
        $result = db_fetch("*", TB_AI_PROMPT_CATEGORIES, ["status" => 1], "created", "ASC");
        $templates = db_fetch("*", TB_AI_PROMPT_TEMPLATES, ["status" => 1], "created", "ASC");

        $data_content = [
            "result" => $result,
            "templates" => $templates,
            "config" => $this->config, 
            "name" => $name
        ];

        return view('Core\Ai_content_generator\Views\popup', $data_content);
    }
}