<?php
namespace Core\Teams\Controllers;

class Teams extends \CodeIgniter\Controller
{
    public function __construct(){
        $this->config = parse_config( include realpath( __DIR__."/../Config.php" ) );
        $this->model = new \Core\Teams\Models\TeamsModel();
    }
    
    public function index( $page = false, $ids = false ) {
        $result = $this->model->get_team_members();

        $data = [
            "title" => $this->config['name'],
            "desc" => $this->config['desc'],
            "result" => $result
        ];

        switch ( $page ) {
            case 'update':
                $item = $this->model->get_team_member( $ids );
                $data['content'] = view('Core\Teams\Views\update', [
                    "item" => $item,
                    "permissions" => $this->model->permissions()
                ]);
                break;

            default:
                $data['content'] = view('Core\Teams\Views\empty', []);
                break;
        }

        return view('Core\Teams\Views\index', $data);
    }

    public function save($ids = ""){
        $uid = get_user("id");
        $team_id = get_team("id");
        $team_ids = get_team("ids");
        $email = post('email');
        $permissions = post('permissions');
        $permissions_show = $this->model->permissions();
        $permissions_show_arr = [];
        $full_permissions = get_team("permissions");
        $full_permissions = json_decode($full_permissions, 1);

        if ($permissions_show) {
            foreach ($permissions_show as $key => $rows) {
                if(!empty($rows)){
                    foreach ($rows as $value) {
                        if(isset($value["sub_menu"]) && isset($value["sub_menu"]["id"])){
                            $permissions_show_arr[] = $value["sub_menu"]["id"];
                        }else{
                            $permissions_show_arr[] = $value["id"];
                        }

                        if (isset($value['data']) && is_array($value['data'])) {
                            if(  isset($value['data']['items']) && is_array($value['data']['items']) ){
                                foreach ($value['data']['items'] as $sub_key => $sub){
                                    $permissions_show_arr[] = $sub["id"];
                                }
                            }
                        }
                    }
                }
            }
        }

        if(!empty($permissions_show_arr) && !empty($permissions)){
            foreach ($permissions_show_arr as $key => $value) {

                if(  isset($permissions[$value]) ){
                    unset($permissions_show_arr[$key]);
                }
            }
        }

        if (!empty($full_permissions) && !empty($permissions_show_arr)) {
            foreach ($full_permissions as $key => $value) {
                if( in_array($key, $permissions_show_arr, true) ){
                    unset($full_permissions[$key]);
                }
            }
        }


        if(!empty($permissions)){
            foreach ($permissions as $key => $value) {
                if( !isset( $full_permissions[$key] ) ){
                    unset( $permissions[$key] );
                    continue;
                }
            }
        }

        $item = db_get("*", TB_TEAM_MEMBER, ["ids" => $ids]);
        if(empty($item)){
            $item = db_get("*", TB_TEAM_MEMBER, ["pending" => $email]);
            if(empty($item)){
                $user = db_get("*", TB_USERS, ["email" => $email]);

                if(!empty($user)){
                    if($user->id == $uid){
                        ms([
                            "status" => "error",
                            "message" => __('You cannot add yourself to the team')
                        ]);
                    }
                    
                    $item = db_get("*", TB_TEAM_MEMBER, ["uid" => $user->id, "team_id" => $team_id]);
                }

            }

            validate('email', "", $email);
            validate('not_empty', __('This member already exists'), $item);

            db_insert(TB_TEAM_MEMBER , [
                "ids" => ids(),
                "uid" => 0,
                "team_id" => $team_id,
                "permissions" => json_encode($full_permissions),
                "pending" => $email,
                "status" => 0
            ]);

            go_mail([
                "email" => $email,
                "subject" => __( "Please confirm your team's contact email." ),
                "content" => __( "Please click the link below to confirm your team's email address" )."<br/><br/>".base_url("?join_team=".$team_ids)
            ]);
        }else{
            db_update(
                TB_TEAM_MEMBER, 
                [
                    "permissions" => json_encode($full_permissions)
                ], 
                ["ids" => $ids]
            );
        }

        ms([
            "status" => "success",
            "message" => __('Success')
        ]);
    }

    public function resend($ids = ""){
        $team_id = get_team("id");
        $team_ids = get_team("ids");
        $team_member = db_get("*", TB_TEAM_MEMBER, ["team_id" => $team_id, "ids" => $ids]);
        if(empty($team_member)){
            ms([
                "status" => "error",
                "message" => __("Cannot send email to this team")
            ]);
        }

        if($team_member->pending == ""){
            ms([
                "status" => "error",
                "message" => __("This team member is team is already activated")
            ]);
        }

        go_mail([
            "email" => $team_member->pending,
            "subject" => __( "Please confirm your team's contact email." ),
            "content" => __( "Please click the link below to confirm your team's email address" )."<br/><br/>".base_url("?join_team=".$team_ids)
        ]);

        ms([
            "status" => "success",
            "message" => __('Success')
        ]);
    }

    public function delete( $ids = '' ){
        $team_id = get_team("id");
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
                db_delete(TB_TEAM_MEMBER, ['ids' => $id, 'team_id' => $team_id]);
            }
        }
        elseif( is_string($ids) )
        {
            db_delete(TB_TEAM_MEMBER, ['ids' => $ids, 'team_id' => $team_id]);
        }

        ms([
            "status" => "success",
            "message" => __('Success')
        ]);
    }
}