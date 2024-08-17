<?php
namespace Core\Whatsapp_contact\Controllers;

class Whatsapp_contact extends \CodeIgniter\Controller
{
    public function __construct(){
        $this->config = parse_config( include realpath( __DIR__."/../Config.php" ) );
        $this->model = new \Core\Whatsapp_contact\Models\Whatsapp_contactModel();
    }
    
    public function index( $page = false, $ids = false ) {
        $data = [
            "title" => $this->config['name'],
            "desc" => $this->config['desc'],
        ];

        switch ( $page ) {
            case 'phone_numbers':
                $team_id = get_team("id");
                $item = false;
                if( $ids ){
                    $item = db_get("*", TB_WHATSAPP_CONTACTS, [ "ids" => $ids, "team_id" => $team_id ]);
                }

                if(empty($item))  redirect_to( get_module_url() );


                $total = $this->model->get_list_phone_numbers(false, $item->id);

                $datatable = [
                    "total_items" => $total,
                    "per_page" => 50,
                    "current_page" => 1,

                ];

                $data_content = [
                    'contact' => $item,
                    'total' => $total,
                    'datatable'  => $datatable,
                    'config'  => $this->config,
                ];

                $data['content'] = view('Core\Whatsapp_contact\Views\phone_numbers', $data_content );
                break;

            case 'update':
                $team_id = get_team("id");
                $item = false;
                if( $ids ){
                    $item = db_get("*", TB_WHATSAPP_CONTACTS, [ "ids" => $ids, "team_id" => $team_id ]);
                }

                $data['content'] = view('Core\Whatsapp_contact\Views\update', ["result" => $item, "config" => $this->config]);
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

                $data['content'] = view('Core\Whatsapp_contact\Views\content', $data_content );
                break;
        }

        return view('Core\Whatsapp\Views\index', $data);
    }

    public function popup_import_contact($ids = false){
        $team_id = get_team("id");
        $item = false;
        if( $ids ){
            $item = db_get("*", TB_WHATSAPP_CONTACTS, [ "ids" => $ids, "team_id" => $team_id ]);
        }

        $data = [
            'config'  => $this->config,
            'result' => $item
        ];
        return view('Core\Whatsapp_contact\Views\popup_import_contact', $data);
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
            "data" => view('Core\Whatsapp_contact\Views\ajax_list', $data)
        ] );
    }

    public function ajax_list_phone_numbers($ids = ""){
        $total_items = $this->model->get_list_phone_numbers(false, $ids);
        $result = $this->model->get_list_phone_numbers(true, $ids);
        $data = [
            "result" => $result,
            "config" => $this->config
        ];
        ms( [
            "total_items" => $total_items,
            "data" => view('Core\Whatsapp_contact\Views\ajax_list_phone_numbers', $data)
        ] );
    }

    public function save($ids = "")
    {
        $status = post('status');
        $name = post('name');
        $team_id = get_team("id");

        $item = db_get("*", TB_WHATSAPP_CONTACTS, "ids = '{$ids}'");
        if(!$item){
            $total_contact_group = db_get("count(id) as count", TB_WHATSAPP_CONTACTS, ["team_id" => $team_id]);
            $max_contact_group = (int)permission('whatsapp_bulk_max_contact_group');
            if($max_contact_group <= $total_contact_group->count){
                ms([
                    "status" => "error",
                    "message" => sprintf( __( 'You can only create a maximum of %s contact groups' ), $max_contact_group )
                ]);
            }

            $item = db_get("*", TB_WHATSAPP_CONTACTS, "name = '{$name}'");
            validate('null', __('Group contact name'), $name);

            db_insert(TB_WHATSAPP_CONTACTS , [
                "ids" => ids(),
                "team_id" => $team_id,
                "name" => $name,
                "status" => $status,
                "changed" => time(),
                "created" => time()
            ]);
        }else{
            $item = db_get("*", TB_WHATSAPP_CONTACTS, "ids != '{$ids}' AND name = '{$name}'");
            validate('null', __('Group contact name'), $name);
            validate('not_empty', __('This group contact name already exists'), $item);

            db_update(
                TB_WHATSAPP_CONTACTS, 
                [
                    "team_id" => $team_id,
                    "name" => $name,
                    "status" => $status,
                    "changed" => time()
                ], 
                array("ids" => $ids)
            );
        }

        ms([
            "status" => "success",
            "message" => __('Success')
        ]);

    }

    public function delete($ids = ""){
        $team_id = get_team("id");
        if( empty($ids) ){
            ms([
                "status" => "error",
                "message" => __('Please select an item to delete')
            ]);
        }

        if( is_array($ids) ){
            foreach ($ids as $id) {
                $item = db_get("*", TB_WHATSAPP_CONTACTS, ["ids" => $id, "team_id" => $team_id]);
                if(!empty($item)){
                    db_delete(TB_WHATSAPP_CONTACTS, ['ids' => $id, "team_id" => $team_id]);
                    db_delete(TB_WHATSAPP_PHONE_NUMBERS, ['pid' => $item->id, "team_id" => $team_id]);
                }
            }
        }
        elseif( is_string($ids) )
        {
            $item = db_get("*", TB_WHATSAPP_CONTACTS, ["ids" => $ids, "team_id" => $team_id]);
            if(!empty($item)){
                db_delete(TB_WHATSAPP_CONTACTS, ['ids' => $ids, "team_id" => $team_id]);
                db_delete(TB_WHATSAPP_PHONE_NUMBERS, ['pid' => $item->id, "team_id" => $team_id]);
            }
        }

        ms([
            "status" => "success",
            "message" => __('Success')
        ]);
    }

    public function download_example_upload_csv(){
        $filename = FCPATH.get_module_dir(__DIR__, 'Assets/csv_template.csv');
        if(file_exists($filename)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header("Cache-Control: no-cache, must-revalidate");
            header("Expires: 0");
            header('Content-Disposition: attachment; filename="'.basename($filename).'"');
            header('Content-Length: ' . filesize($filename));
            header('Pragma: public');
            flush();
            readfile($filename);
        }else{
            redirect_to( get_module_url() );
        }
    }

    public function add_contact($ids = ""){
        $team_id = get_team("id");
        $phone_numbers = post("phone_numbers");
        validate('null', __('Phone numbers'), $phone_numbers);
        $phone_numbers = explode("\n", $phone_numbers);

        $item = db_get("*", TB_WHATSAPP_CONTACTS, ["ids" => $ids, "team_id" => $team_id]);

        if(!empty($item)){
            $total_phone_numbers = db_get("count(id) as count", TB_WHATSAPP_PHONE_NUMBERS, ["team_id" => $team_id, "pid" => $item->id]);
            $max_phone_number = (int)permission('whatsapp_bulk_max_phone_numbers');

            if($max_phone_number < $total_phone_numbers->count + count($phone_numbers)){
                ms([
                    "status" => "error",
                    "message" => sprintf( __( 'You can only add up to %s phone numbers per contact group' ), $max_phone_number )
                ]);
            }

            $data = [];

            foreach ($phone_numbers as $key => $phone_number) {
                $phone_number = str_replace("+", "", $phone_number);
                $phone_number = str_replace(" ", "", $phone_number);
                $phone_number = str_replace("'", "", $phone_number);
                $phone_number = str_replace("`", "", $phone_number);
                $phone_number = str_replace("\"", "", $phone_number);
                $phone_number = trim($phone_number);

                if(is_numeric($phone_number) || stripos($phone_number, "@g.us") !== false){

                    $data[] = [
                        "ids" => ids(),
                        "team_id" => $item->team_id,
                        "pid" => $item->id,
                        "phone" => $phone_number,
                    ];
                }
            }

            if(!empty($data)){
                db_insert(TB_WHATSAPP_PHONE_NUMBERS, $data);
            }
        }

        ms([
            "status" => "success",
            "message" => __('Success')
        ]);
    }

    public function do_import_contact($ids= ""){
        $team_id = get_team("id");
        $max_size = 10*1024;
        $file_path = "";
        $item = db_get("*", TB_WHATSAPP_CONTACTS, ["ids" => $ids, "team_id" => $team_id]);

        if(empty($item)){
            ms([
                "status" => "error",
                "message" => __('Contact group is not exist')
            ]);
        }

        if(!empty($_FILES) && is_array($_FILES['files']['name'])){
            if(empty( $this->request->getFiles() )){
                ms([
                    "status" => "error",
                    "message" => __('Cannot found files csv to upload')
                ]);
            }

            $check_mime = $this->validate([
                'files' => [
                    'uploaded[files]',
                    'ext_in[files,csv]'
                ],
            ]);

            if(!$check_mime){
                ms([
                    "status" => "error",
                    "message" => "The filetype you are attempting to upload is not allowed"
                ]);
            }

            $check_size = $this->validate([
                'files' => [
                    'uploaded[files]',
                    'max_size[files,'.$max_size.']'
                ],
            ]);

            if(!$check_size){
                ms([
                    "status" => "error",
                    "message" => __( sprintf("Unable to upload a file larger than %sMB", $maxsize) )
                ]);
            }

            if ($file = $this->request->getFiles()) {
                if( isset( $file['files'] ) ){
                    foreach($file['files'] as $img) {
                        if ($img->isValid() && ! $img->hasMoved()) {
                            $newName = $img->getRandomName();
                            $img->move(WRITEPATH.'uploads', $newName);
                            $file_path = WRITEPATH.'uploads/'.$newName;
                        }
                    }
                }
            }
        }

        if($file_path == ""){
            ms([
                "status" => "error",
                "message" => __("Upload csv file failed.")
            ]);
        }

        $csvReader = new \yidas\csv\Reader($file_path);
        $csvFile = $csvReader->readRows();

        $count_phone_numbers = count($csvFile) - 1;

        $total_phone_numbers = db_get("count(id) as count", TB_WHATSAPP_PHONE_NUMBERS, ["team_id" => $team_id, "pid" => $item->id]);
        $max_phone_number = (int)permission('whatsapp_bulk_max_phone_numbers');

        if($max_phone_number < $total_phone_numbers->count + $count_phone_numbers){
            ms([
                "status" => "error",
                "message" => sprintf( __( 'You can only add up to %s phone numbers per contact group' ), $max_phone_number )
            ]);
        }

        $headers = [];
        $phone_numbers = [];
        foreach($csvFile as $key => $row) {
            if( $key != 0 ){
                if(is_array($row )){
                    $phone_number = $row[0];
                }
                
                $phone_number = str_replace("+", "", $phone_number);
                $phone_number = str_replace(" ", "", $phone_number);
                $phone_number = str_replace("'", "", $phone_number);
                $phone_number = str_replace("`", "", $phone_number);
                $phone_number = str_replace("\"", "", $phone_number);
                $phone_number = trim($phone_number);
                
                $params = NULL;
                if(is_numeric($phone_number) || stripos($phone_number, "@g.us") !== false){
                    if(count($row) > 0){
                        
                        $params = [];
                        foreach ($row as $param_key => $value) {
                            if($param_key != 0 ){
                                if($value != ""){
                                    $params[ $headers[$param_key-1] ] = $value;
                                }
                            }
                        }
                    }

                    $phone_numbers[] = [
                        "ids" => ids(),
                        "team_id" => $item->team_id,
                        "pid" => $item->id,
                        "phone" => $phone_number,
                        "params" => json_encode($params),
                    ];
                }
            }else{
                if(!empty($row)){
                    foreach ($row as $pos => $value) {
                        if($pos != 0){
                            $headers[] = $value;
                        }
                    }
                }
            }
        }

        if(!empty($phone_numbers)){
            db_insert( TB_WHATSAPP_PHONE_NUMBERS, $phone_numbers );
        }

        unlink($file_path);

        ms([
            "status" => "success",
            "message" => __('Success')
        ]);
    }

    public function delete_phone(){
        $team_id = get_team("id");
        $ids = post('ids');

        if( empty($ids) ){
            ms([
                "status" => "error",
                "message" => __('Please select an item to delete')
            ]);
        }

        if( is_array($ids) ){
            foreach ($ids as $id) {
                db_delete(TB_WHATSAPP_PHONE_NUMBERS, ['ids' => $id, "team_id" => $team_id]);
            }
        }
        elseif( is_string($ids) )
        {
            db_delete(TB_WHATSAPP_PHONE_NUMBERS, ['ids' => $ids, "team_id" => $team_id]);
        }

        ms([
            "status" => "success",
            "message" => __('Success')
        ]);
    }
}