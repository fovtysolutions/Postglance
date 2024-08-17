<?php
if(post('join_team') && post('join_team') != ""){
    $ids = addslashes( post('join_team') );
    $result = db_get("*", TB_TEAM, [ "ids" => $ids ]);

    if(!empty($result)){
        set_session(["join_team" => $result->ids]);
        redirect_to( base_url("dashboard") );
    }
}

if( get_session("join_team") ){
    $uid = get_user("id");
    $email = get_user("email");
    $team_id = get_session("join_team");
    $user = db_get("*", TB_USERS, ["id" => $uid]);

    if(!empty($user)){
        $team = db_get("*", TB_TEAM, ["ids" => $team_id]);
        
        if(!empty($team)){
            $team_member = db_get("*", TB_TEAM_MEMBER, ["team_id" => $team->id, "pending" => $user->email]);

            if(!empty($team_member)){
                db_update(TB_TEAM_MEMBER, ["uid" => $user->id, "pending" => NULL, "status" => 1], ["id" => $team_member->id]);
                remove_session(["join_team"]);
                redirect_to( base_url("dashboard") );
            }
        }
        remove_session(["join_team"]);
    }
}