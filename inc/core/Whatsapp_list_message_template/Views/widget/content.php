<div class="tab-pane fade show <?php _ec( get_data($result, "type") == 3?"active":"" ) ?>" id="wa_list_message">
    <label class="form-label"><?php _e("List message templates")?></label>
    <div class="card border">
        <div class="card-body p-0">
            <?php if (!empty($list_msg_templates)): ?>
                
                <?php foreach ($list_msg_templates as $key => $value): ?>
                <div class="item px-4 py-4 border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <label class="form-check-label" for="list_msg_<?php _ec( get_data($value, "id") )?>"><?php _ec( get_data($value, "name") )?></label>
                        <span>
                            <input class="form-check-input" type="radio" name="list_msg" <?php _ec( get_data($result, "template", "radio", $value->id) ) ?> id="list_msg_<?php _ec( get_data($value, "id") )?>" value="<?php _ec( get_data($value, "id") )?>">
                        </span>
                    </div>
                </div>
                <?php endforeach ?>

            <?php else: ?>
                <div class="d-flex align-items-center align-self-center h-100 py-5">
                    <div class="w-100">
                        <div class="text-center px-4">
                            <img class="mh-190 mb-4" alt="" src="<?php _e( get_theme_url() ) ?>Assets/img/empty2.png">
                            <div>
                                <a class="btn btn-primary btn-sm b-r-30" href="<?php _e( base_url("whatsapp_list_message_template/index/update") )?>" >
                                    <i class="fad fa-plus"></i> <?php _ec("Add list message template")?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>