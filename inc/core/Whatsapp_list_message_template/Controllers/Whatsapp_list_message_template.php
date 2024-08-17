<?php
namespace Core\Whatsapp_list_message_template\Controllers;

class Whatsapp_list_message_template extends \CodeIgniter\Controller
{
    public function __construct(){
        $this->config = parse_config( include realpath( __DIR__."/../Config.php" ) );
        $this->model = new \Core\Whatsapp_list_message_template\Models\Whatsapp_list_message_templateModel();
    }
    
    public function index( $page = false, $ids = false ) {
        $data = [
            "title" => $this->config['name'],
            "desc" => $this->config['desc'],
        ];

        switch ( $page ) {
            case 'update':
                $item = false;
                if( $ids ){
                    $team_id = get_team("id");
                    $item = db_get("*", TB_WHATSAPP_TEMPLATE, ["type" => 1, "ids" => $ids, "team_id" => $team_id]);
                }

                $data['content'] = view('Core\Whatsapp_list_message_template\Views\update', ["result" => $item, "config" => $this->config]);
                break;

            default:
                $total = $this->model->get_list(false);

                $datatable = [
                    "total_items" => $total,
                    "per_page" => 30,
                    "current_page" => 1,

                ];

                $data_content = [
                    'total' => $total,
                    'datatable'  => $datatable,
                    'config'  => $this->config,
                ];

                $data['content'] = view('Core\Whatsapp_list_message_template\Views\content', $data_content );
                break;
        }

        return view('Core\Whatsapp\Views\index', $data);
    }

    public function widget_menu( $params = [] ){
        if ( !permission("whatsapp_list_message_template") ) return "";
        $result = $params['result'];
        return view('Core\Whatsapp_list_message_template\Views\widget\menu', ["result" => $result]);
    }

    public function widget_content( $params = [] ){
        if ( !permission("whatsapp_list_message_template") ) return "";
        $team_id = get_team("id");
        $list_msg_templates = db_fetch("*", TB_WHATSAPP_TEMPLATE, ["type" => 1, "team_id" => $team_id]);
        return view('Core\Whatsapp_list_message_template\Views\widget\content', ["result" => $params["result"], "list_msg_templates" => $list_msg_templates]);
    }

    public function ajax_list(){
        $total_items = $this->model->get_list(false);
        $result = $this->model->get_list(true);
        $data = [
            "result" => $result,
            "config" => $this->config
        ];
        ms( [
            "total_items" => $total_items,
            "data" => view('Core\Whatsapp_list_message_template\Views\ajax_list', $data)
        ] );
    }

    public function save( $ids = false ){
        $name = post("name");
        $menu_title = post("menu_title");
        $menu_desc = post("menu_desc");
        $menu_footer = post("menu_footer");
        $menu_button = post("menu_button");
        $section_name = post("section_name");
        $advance_options = post("advance_options");
        $options = post("options");
        $team_id = get_team("id");
        $shortlink_by = false;
        if(!empty($advance_options) && isset($advance_options['shortlink'])){
            $shortlink_by = shortlink_by(['advance_options' => [ 'shortlink' => $advance_options['shortlink'] ]]);
        }

        if($name==""){
            ms([
                "status" => "error",
                "message" => __('Template name is required')
            ]);
        }

        if($menu_title==""){
            ms([
                "status" => "error",
                "message" => __('Menu title is required')
            ]);
        }

        if($menu_desc==""){
            ms([
                "status" => "error",
                "message" => __('Menu description is required')
            ]);
        }

        if($menu_footer==""){
            ms([
                "status" => "error",
                "message" => __('Menu footer is required')
            ]);
        }

        if($menu_button==""){
            ms([
                "status" => "error",
                "message" => __('Menu button is required')
            ]);
        }

        if( empty($section_name) ){
            ms([
                "status" => "error",
                "message" => __('Add at least one section')
            ]);
        }

        $sections_arr = [];
        $list_message = [];

        foreach ($section_name as $key => $section) {

            $section_item = ['title' => $section, 'rows' => [] ];

            if( !isset($section) || $section == "" ){
                ms([
                    "status" => "error",
                    "message" => sprintf( __("Section %s: Section name is required") , $key )
                ]);
            }

            if( !isset($options[$key]) || count($options[$key]) == 0 || !isset($options[$key]['name']) || !isset($options[$key]['desc'])){
                ms([
                    "status" => "error",
                    "message" => sprintf( __("Section %s: Add at least one option") , $key )
                ]);
            }

            if( count(  $options[$key]['name'] ) != count($options[$key]['desc']) ){
                ms([
                    "status" => "error",
                    "message" => sprintf( __("Section %s: Invalid input data") , $key )
                ]);
            }

            foreach ($options[$key]['name'] as $option_key => $option_value) {
                $option_value = trim($option_value);
                if($option_value == ""){
                    ms([
                        "status" => "error",
                        "message" => __('The option name is required')
                    ]);
                }

                $section_item['rows'][] = [
                    "title" => $option_value,
                    "rowId" => ids(),
                    "description" => $options[$key]['desc'][$option_key]
                ];
            }

            $sections_arr[] = $section_item;
        }

        $menu_title = shortlink($menu_title, $shortlink_by);
        $menu_desc = shortlink($menu_desc, $shortlink_by);
        $menu_footer = shortlink($menu_footer, $shortlink_by);

        $list_message = [
            "text" => $menu_desc,
            "footer" => $menu_footer,
            "title" => $menu_title,
            "buttonText" => $menu_button,
            "sections" => $sections_arr
        ];

        $item = db_get("*", TB_WHATSAPP_TEMPLATE, ["ids" => $ids, "team_id" => $team_id]);
        if( empty($item) ){
            $data = [
                "ids" => ids(),
                "team_id" => $team_id,
                "type" => 1,
                "name" => $name,
                "data" => json_encode($list_message),
                "changed" => time(),
                "created" => time(),
            ];
            
            db_insert( TB_WHATSAPP_TEMPLATE, $data );
        }else{
            $data = [
                "name" => $name,
                "data" => json_encode($list_message),
                "changed" => time(),
            ];
            
            db_update( TB_WHATSAPP_TEMPLATE, $data, ["ids" => $ids] );
        }

        ms([
            "status" => "success",
            "message" => __('Success')
        ]);
    }

    public function delete(){
        $team_id = get_team("id");
        $ids = post('id');

        if( empty($ids) ){
            ms([
                "status" => "error",
                "message" => __('Please select an item to delete')
            ]);
        }

        if( is_array($ids) ){
            foreach ($ids as $id) {
                db_delete(TB_WHATSAPP_TEMPLATE, ['ids' => $id, "team_id" => $team_id]);
            }
        }
        elseif( is_string($ids) )
        {
            db_delete(TB_WHATSAPP_TEMPLATE, ['ids' => $ids, "team_id" => $team_id]);
        }

        ms([
            "status" => "success",
            "message" => __('Success')
        ]);
    }
}