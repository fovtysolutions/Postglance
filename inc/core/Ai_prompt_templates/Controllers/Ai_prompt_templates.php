<?php
namespace Core\Ai_prompt_templates\Controllers;

class Ai_prompt_templates extends \CodeIgniter\Controller
{
    public function __construct(){
        $this->config = parse_config( include realpath( __DIR__."/../Config.php" ) );
        $this->model = new \Core\Ai_prompt_templates\Models\Ai_prompt_templatesModel();
    }
    
    public function index( $page = false, $ids = "" ) {
        // $result = db_fetch("*", TB_AI_PROMPT_CATEGORIES, [], "created", "ASC");
        $result = '';

        $data = [
            "result" => $result,
            "title" => $this->config['menu']['name'],
            "desc" => $this->config['desc'],
            "config" => $this->config,
        ];

        switch ( $page ) {
            case 'update_prompt':
                $category = db_get("*", TB_AI_PROMPT_CATEGORIES, [ "ids" => $ids ]);
                if(empty($category)){
                    redirect_to( get_module_url() );
                }

                $data['content'] = view('Core\Ai_prompt_templates\Views\update_prompt', ["config" => $this->config, "category" => $category]);
                break;

            case 'list':
                $category = db_get("*", TB_AI_PROMPT_CATEGORIES, [ "ids" => $ids ]);

                if(empty($category)){
                    redirect_to( get_module_url() );
                }

                $start = 0;
                $limit = 1;

                $pager = \Config\Services::pager();
                $total = $this->model->get_list(false, $category->id);

                $datatable = [
                    "responsive" => true,
                    "columns" => [
                        "id" => __("ID"),
                        "pid" => __("Category"),
                        "content" => __("Prompt"),
                        "status" => __("Status")
                    ],
                    "total_items" => $total,
                    "per_page" => 50,
                    "current_page" => 1,

                ];

                $data_content = [
                    'start' => $start,
                    'limit' => $limit,
                    'total' => $total,
                    'pager' => $pager,
                    'category' => $category,
                    'datatable'  => $datatable,
                    'config' => $this->config
                ];

                $data['content'] = view('Core\Ai_prompt_templates\Views\list', $data_content);
                break;

            case 'update':
                $item = false;
                $ids = uri('segment', 4);
                if( $ids ){
                    $item = db_get("*", TB_AI_PROMPT_CATEGORIES, [ "ids" => $ids ]);
                }

                $data['content'] = view('Core\Ai_prompt_templates\Views\update', ["config" => $this->config, "result" => $item]);
                break;

            default:
                $data['content'] = view('Core\Ai_prompt_templates\Views\empty');
                break;
        }

        return view('Core\Ai_prompt_templates\Views\index', $data);
    }

    public function ajax_list($ids = ""){
        $category = db_get("*", TB_AI_PROMPT_CATEGORIES, [ "ids" => $ids ]);

        if(empty($category)){
            return false;
        }

        $total_items = $this->model->get_list(false, $category->id);
        $result = $this->model->get_list(true, $category->id);
        $data = [
            "result" => $result,
            "category" => $category,
        ];
        ms( [
            "total_items" => $total_items,
            "data" => view('Core\Ai_prompt_templates\Views\ajax_list', $data)
        ] );
    }

    public function popup_add_prompt($ids = "", $item_ids = ""){
        $categories = db_fetch("*", TB_AI_PROMPT_CATEGORIES, [], "created", "ASC");
        $category_item = db_get("*", TB_AI_PROMPT_CATEGORIES, [ "ids" => $ids ]);
        $result = db_get("*", TB_AI_PROMPT_TEMPLATES, [ "ids" => $item_ids ]);

        $data = [
            "result" => $result,
            "categories" => $categories,
            "category_item" => $category_item
        ];

        return view('Core\Ai_prompt_templates\Views\popup_add_prompt', $data);
    }

    public function save( $ids = "" ){
        $name = post("name");
        $icon = post("icon");
        $status = (int)post("status");
        $desc = post("desc");
        $item = false;

        if ($ids != "") {
            $item = db_get("*", TB_AI_PROMPT_CATEGORIES, ["ids" => $ids]);
        }

        if (!$this->validate([
            'name' => 'required'
        ])) {
            ms([
                "status" => "error",
                "message" => __("Category name is required")
            ]);
        }

        if (!$this->validate([
            'icon' => 'required'
        ])) {
            ms([
                "status" => "error",
                "message" => __("Category icon is required")
            ]);
        }

        $data = [
            "name" => $name,
            "desc" => $desc,
            "icon" => $icon,
            "status" => $status,
            "changed" => time(),
        ];

        if( empty($item) ){
            $data['ids'] = ids();
            $data['created'] = time();

            db_insert(TB_AI_PROMPT_CATEGORIES, $data);
        }else{
            db_update(TB_AI_PROMPT_CATEGORIES, $data, [ "id" => $item->id ]);
        }

        ms([
            "status" => "success",
            "message" => __('Success')
        ]);
    }

    public function save_prompt($ids = ""){
        $prompt = post("prompt");
        $category = post("category");
        $status = (int)post("status");

        $item = db_get("*", TB_AI_PROMPT_TEMPLATES, ["ids" => $ids]);
        $category = db_get("*", TB_AI_PROMPT_CATEGORIES, ["ids" => $category]);

        if(empty($category)){
            ms([
                "status" => "error",
                "message" => __("Category is required")
            ]);
        }

        if (!$this->validate([
            'prompt' => 'required'
        ])) {
            ms([
                "status" => "error",
                "message" => __("Prompt is required")
            ]);
        }

        $data = [
            "pid" => $category->id,
            "content" => $prompt,
            "status" => $status,
            "changed" => time(),
        ];

        if( empty($item) ){
            $data['ids'] = ids();
            $data['created'] = time();

            db_insert(TB_AI_PROMPT_TEMPLATES, $data);
        }else{
            db_update(TB_AI_PROMPT_TEMPLATES, $data, [ "id" => $item->id ]);
        }

        ms([
            "status" => "success",
            "message" => __('Success')
        ]);
    }

    public function delete( $ids = '' ){
        if($ids == ''){
            $ids = post('id');
        }

        if( empty($ids) ){
            ms([
                "status" => "error",
                "message" => __('Please select an item to delete')
            ]);
        }

        if( is_array($ids) )
        {
            foreach ($ids as $id) 
            {
                db_delete(TB_AI_PROMPT_CATEGORIES, ['ids' => $id]);
            }
        }
        elseif( is_string($ids) )
        {
            db_delete(TB_AI_PROMPT_CATEGORIES, ['ids' => $ids]);
        }

        ms([
            "status" => "success",
            "message" => __('Success')
        ]);
    }

    public function delete_prompt( $ids = '' ){
        if($ids == ''){
            $ids = post('id');
        }

        if( empty($ids) ){
            ms([
                "status" => "error",
                "message" => __('Please select an item to delete')
            ]);
        }

        if( is_array($ids) )
        {
            foreach ($ids as $id) 
            {
                db_delete(TB_AI_PROMPT_TEMPLATES, ['ids' => $id]);
            }
        }
        elseif( is_string($ids) )
        {
            db_delete(TB_AI_PROMPT_TEMPLATES, ['ids' => $ids]);
        }

        ms([
            "status" => "success",
            "message" => __('Success')
        ]);
    }
}