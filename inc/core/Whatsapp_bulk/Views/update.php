<form class="actionForm" action="<?php _eC( get_module_url("save/".get_data($result, "ids")) )?>" method="POST" data-redirect="<?php _ec( get_module_url() )?>">
    <div class="container my-5">
        <div class="bd-search position-relative me-auto">
            <h2 class="mb-0 py-4"> <i class="<?php _ec( $config['icon'] )?> me-2" style="color: <?php _ec( $config['color'] )?>;"></i> <?php _e( $config['name'] )?></h2>
        </div>

        <div class="card b-r-6 h-100 post-schedule wrap-caption">
            <div class="card-header">
                <h3 class="card-title"><?php _e("Update campaign")?></h3>
                <div class="card-toolbar"></div>
            </div>
            <div class="card-body position-relative">
                <div class="mb-3">
                    <label class="form-label"><?php _e("Select WhatsApp accounts")?></label>
                    <?php echo view_cell('\Core\Account_manager\Controllers\Account_manager::widget', [ "whereIn" => ["id" => json_decode( get_data($result, "accounts") ) ] ,"wheres" => ["social_network" => "whatsapp", "login_type" => 2, "status" => 1, "team_id" => get_team("id")] ]) ?>
                </div>

                <div class="mb-3">
                    <label class="form-label"><?php _e("Campaign name")?></label>
                    <input type="text" class="form-control form-control-solid" name="name" value="<?php _ec( get_data($result, "name") )?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label"><?php _e("Contact group")?></label>
                    <select class="form-select form-select-solid" name="group" required>
                        <option value=""><?php _e("Select contact group")?></option>
                        <?php if (!empty($contacts)): ?>
                            <?php foreach ($contacts as $key => $value): ?>
                                <option value="<?php _ec($value->id)?>" <?php _ec( get_data($result, "contact_id", "select", $value->id) )?> ><?php _ec($value->name)?></option>
                            <?php endforeach ?>
                        <?php endif ?>
                    </select>
                </div>

                <ul class="nav nav-pills mb-3 bg-white rounded fs-14 nx-scroll overflow-x-auto d-flex text-over b-r-6 border" id="pills-tab">
                    <li class="nav-item me-0">
                         <label for="type_text_media" class="nav-link bg-active-primary text-gray-700 px-4 py-3 b-r-6 text-active-white <?php _ec( (get_data($result, "type") == 1 || get_data($result, "type") == "")?"active":"" ) ?>" data-bs-toggle="pill" data-bs-target="#wa_text_and_media" type="button" role="tab"><?php _e("Text & Media")?></label>
                         <input class="d-none" type="radio" name="type" id="type_text_media" <?php _ec( (get_data($result, "type") == 1 || get_data($result, "type") == "")?"checked='true'":"" ) ?> value="1">
                    </li>
                    <?php echo view_cell('\Core\Whatsapp_button_template\Controllers\Whatsapp_button_template::widget_menu', ["result" => $result]) ?>
                    <?php echo view_cell('\Core\Whatsapp_list_message_template\Controllers\Whatsapp_list_message_template::widget_menu', ["result" => $result]) ?>
                </ul>

                <div class="tab-content mb-3" id="pills-tabContent">
                    <div class="tab-pane fade show <?php _ec( (get_data($result, "type") == 1 || get_data($result, "type") == "")?" active":"" ) ?>" id="wa_text_and_media">
                        <?php echo view_cell('\Core\Whatsapp\Controllers\Whatsapp::widget_content', ["result" => $result]) ?>
                        <label class="form-label"><?php _e("Caption")?></label>
                        <?php echo view_cell('\Core\Caption\Controllers\Caption::block', ['name' => 'caption', 'value' => get_data($result, "caption")]) ?>

                        <ul class="text-gray-400 fs-12">
                            <li><?php _e("Random message by Spintax")?></li>
                            <li><?php _e("Ex: {Hi|Hello|Hola}")?></li>
                        </ul>
                    </div>
                    <?php echo view_cell('\Core\Whatsapp_button_template\Controllers\Whatsapp_button_template::widget_content', ["result" => $result]) ?>
                    <?php echo view_cell('\Core\Whatsapp_list_message_template\Controllers\Whatsapp_list_message_template::widget_content', ["result" => $result]) ?>
                </div>

                <div class="mb-3">
                    <div class="card border b-r-6">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-12 mb-3">
                                    <label class="form-label"><?php _e("Time post")?></label>
                                    <input type="text" class="form-control form-control-solid datetime datetime" autocomplete="off" name="time_post" value="<?php _e( datetime_show( get_data($result, "time_post") ) )?>">
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label"><?php _e("Random message interval by minimum (second)")?></label>
                                    <select class="form-select form-select-solid" name="min_interval_per_post" required>
                                        <option value=""><?php _e("Select min second")?></option>
                                        <?php for($i = 1; $i <= 3600; $i++):?>
                                            <?php if ($i  <= 100): ?>
                                                <option value="<?php _ec( $i )?>" <?php _ec( get_data($result, "min_delay", "select", $i) )?> ><?php _e( sprintf("%s seconds", $i) )?></option>
                                            <?php elseif($i%5==0): ?>
                                                <option value="<?php _ec( $i )?>" <?php _ec( get_data($result, "min_delay", "select", $i) )?> ><?php _e( sprintf("%s seconds", $i) )?></option>
                                            <?php endif ?>
                                        <?php endfor ?>
                                    </select>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label"><?php _e("Random message interval by maximum (second)")?></label>
                                    <select class="form-select form-select-solid" name="max_interval_per_post" required>
                                        <option value=""><?php _e("Select max second")?></option>
                                        <?php for($i = 1; $i <= 3600; $i++):?>
                                            <?php if ($i  <= 100): ?>
                                                <option value="<?php _ec( $i )?>" <?php _ec( get_data($result, "max_delay", "select", $i) )?>><?php _e( sprintf("%s seconds", $i) )?></option>
                                            <?php elseif($i%5==0): ?>
                                                <option value="<?php _ec( $i )?>" <?php _ec( get_data($result, "max_delay", "select", $i) )?>><?php _e( sprintf("%s seconds", $i) )?></option>
                                            <?php endif ?>
                                        <?php endfor ?>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label"><?php _e("Schedule time")?></label>

                                    <ul class="d-flex seclect-shedule-time">
                                        <li class="me-4"><a href="javascript:void(0);" data-time="daytime"><?php _e("Daytime")?></a></li>
                                        <li class="me-4"><a href="javascript:void(0);" data-time="nighttime"><?php _e("Nighttime")?></a></li>
                                        <li class="me-4"><a href="javascript:void(0);" data-time="odd"><?php _e("Odd")?></a></li>
                                        <li class="me-4"><a href="javascript:void(0);" data-time="even"><?php _e("Even")?></a></li>
                                    </ul>

                                    <?php
                                        $schedule_time =  get_data($result, "schedule_time");
                                        if($schedule_time != ""){
                                            $schedule_time = json_decode($schedule_time);
                                            if(!is_array($schedule_time)){
                                                $schedule_time = [];
                                            }
                                        }else{
                                            $schedule_time = [];
                                        }
                                    ?>
                                    <select class="form-select form-select-solid schedule_time mb-1" data-control="select2" data-placeholder="<?php _e("Select time")?>" multiple name="schedule_time[]">
                                        <?php for($i = 0; $i <= 23; $i++):?>
                                            <option value="<?php _ec( $i )?>" <?php _ec( in_array($i, $schedule_time)?"selected":"" )?> ><?php _ec( $i )?></option>
                                        <?php endfor ?>
                                    </select>
                                    <p class="fs-12 text-gray-600 mb-1"><?php _e("The schedule allows you to set up a unique schedule by time for your campaign to run")?></p>
                                    <p class="fs-12 text-danger mb-0"><?php _e("Set empty to campaign run anytime")?></p>
                                </div>
                            </div>
            
                        </div>
                    </div>
                </div> 
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-between">
                    <a href="<?php _ec( get_module_url() )?>" class="btn btn-dark btn-hover-scale">
                        <?php _e("Back")?>
                    </a>
                    <button type="submit" class="btn btn-primary btn-hover-scale">
                        <i class="fal fa-paper-plane"></i> <?php _e("Schedule")?>
                    </button>
                </div>
            </div>
        </div>
     
    </div>
</form>

<script type="text/javascript">
$(function(){
    Core.tagsinput();
    <?php if ( get_data($result, "accounts") != ""): ?>
        var accounts = <?php _ec( get_data($result, "accounts") )?>;
        for (var i = 0; i < accounts.length; i++) {
            Account_manager.CheckAndSelect(  $('input#am_'+accounts[i]).parents(".am-choice-item") );
        }
    <?php endif ?>
});
</script> 