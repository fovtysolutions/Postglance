<form class="actionForm" action="<?php _eC( get_module_url("save/".get_data($result, "ids")) )?>" method="POST" data-redirect="<?php _ec( get_module_url("index/list/".$account->ids) )?>">
    <div class="container my-5 mw-800">
        <div class="bd-search position-relative me-auto">
            <h2 class="mb-0 py-4"> <i class="<?php _ec( $config['icon'] )?> me-2" style="color: <?php _ec( $config['color'] )?>;"></i> <?php _e("Chatbot item")?></h2>
        </div>

        <div class="card b-r-6 h-100 post-schedule wrap-caption">
            <div class="card-header">
                <h3 class="card-title"><?php _e("Update")?></h3>
                <div class="card-toolbar"></div>
            </div>
            <div class="card-body position-relative">
                <input type="text" class="form-control form-control-solid d-none" name="instance_id" value="<?php _ec($account->token)?>" required>
                <input type="text" class="form-control form-control-solid d-none" name="ids" value="<?php _ec( get_data($result, "ids") )?>">
                <div class="mb-4">
                    <label class="form-label"><?php _e("Status")?></label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" <?php _ec( (get_data($result, "status") == 1 || get_data($result, "status") == "")?"checked='true'":"" ) ?> id="status_enable" value="1">
                            <label class="form-check-label" for="status_enable"><?php _e('Enable')?></label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" <?php _ec( get_data($result, "status", "radio", 0) ) ?> id="status_disable" value="0">
                            <label class="form-check-label" for="status_disable"><?php _e('Disable')?></label>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label"><?php _e("Send to")?></label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="send_to" <?php _ec( (get_data($result, "send_to") == 1 || get_data($result, "send_to") == "")?"checked='true'":"" ) ?> id="send_to_all" value="1">
                            <label class="form-check-label" for="send_to_all"><?php _e('All')?></label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="send_to" <?php _ec( (get_data($result, "send_to") == 2)?"checked='true'":"" ) ?> id="send_to_individual" value="2">
                            <label class="form-check-label" for="send_to_individual"><?php _e('Individual')?></label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="send_to" <?php _ec( (get_data($result, "send_to") == 3)?"checked='true'":"" ) ?> id="send_to_group" value="3">
                            <label class="form-check-label" for="send_to_group"><?php _e('Group')?></label>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label"><?php _e("Type")?></label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="type_search" <?php _ec( (get_data($result, "type_search") == 1 || get_data($result, "type_search") == "")?"checked='true'":"" ) ?> id="type_search_1" value="1">
                            <label class="form-check-label" for="type_search_1"><?php _e('Message contains the keyword')?></label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="type_search" <?php _ec( (get_data($result, "type_search") == 2)?"checked='true'":"" ) ?> id="type_search_2" value="2">
                            <label class="form-check-label" for="type_search_2"><?php _e('Message contains whole keyword')?></label>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label"><?php _e("Name")?></label>
                    <input type="text" class="form-control form-control-solid" name="name" value="<?php _ec( get_data( $result, "name" ) )?>" required>
                </div>

                <div class="mb-3">
    	            <label for="keywords" class="form-label"><?php _e("Keywords")?></label>
    	            <input type="text" class="form-control form-control-solid" data-role="tagsinput" id="keywords" name="keywords" value="<?php _ec( get_data($result, "keywords") )?>">
            	</div>

                <ul class="nav nav-pills mb-3 bg-white rounded fs-14 nx-scroll overflow-x-auto d-flex text-over b-r-6 border" id="pills-tab">
                    <li class="nav-item me-0">
                         <label for="type_text_media" class="nav-link bg-active-primary text-gray-700 px-4 py-3 b-r-6 text-active-white <?php _ec( (get_data($result, "type") == 1 || get_data($result, "type") == "")?"active":"" ) ?>" data-bs-toggle="pill" data-bs-target="#wa_text_and_media" type="button" role="tab"><?php _e("Text & Media")?></label>
                         <input class="d-none" type="radio" name="type" id="type_text_media" <?php _ec( (get_data($result, "type") == 1 || get_data($result, "type") == "")?"checked='true'":"" ) ?> value="1">
                    </li>
                    <?php echo view_cell('\Core\Whatsapp_button_template\Controllers\Whatsapp_button_template::widget_menu', ["result" => $result]) ?>
                    <?php echo view_cell('\Core\Whatsapp_list_message_template\Controllers\Whatsapp_list_message_template::widget_menu', ["result" => $result]) ?>
                </ul>
                
                <div class="tab-content" id="pills-tabContent">
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
                
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-between">
                    <a href="<?php _ec( get_module_url("index/list/".$account->ids) )?>" class="btn btn-dark btn-hover-scale">
                        <?php _e("Back")?>
                    </a>
                    <button type="submit" class="btn btn-primary btn-hover-scale">
                        <?php _e("Submit")?>
                    </button>
                </div>
            </div>
        </div>
     
    </div>
</form>

<script type="text/javascript">
$(function(){
    Core.tagsinput();
});
</script>
