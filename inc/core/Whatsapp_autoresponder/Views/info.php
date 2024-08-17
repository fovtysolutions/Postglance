<?php if ( $status == "success" ): ?>
<div class="card b-r-6 h-100 post-schedule wrap-caption">
	<div class="card-header">
		<?php if ( !empty($account) ): ?>
			<h3 class="card-title"><?php _e( sprintf("Autoresponder for %s", $account->name) )?></h3>
		<?php else: ?>
			<h3 class="card-title"><?php _ec("Set autoresponder for all account")?></h3>
		<?php endif ?>
        	<div class="card-toolbar"></div>
	</div>
	<div class="card-body position-relative">
		<input type="text" class="form-control form-control-solid d-none" id="instance_id" name="instance_id" value="<?php _ec( get_data($account, "token") )?>">

		<div class="mb-4">
			<label class="form-label"><?php _e("Status")?></label>
			<div>
               <div class="form-check form-check-inline">
                   <input class="form-check-input" type="radio" name="status" <?php _ec( (get_data($result, "status")==1 || get_data($result, "status") == "")?"checked='true'":"" )?> id="status_enable" value="1">
                   <label class="form-check-label" for="status_enable"><?php _e('Enable')?></label>
               </div>
               <div class="form-check form-check-inline">
                   <input class="form-check-input" type="radio" name="status" <?php _ec(get_data($result, "status")==0?"checked='true'":"" )?> id="status_disable" value="0">
                   <label class="form-check-label" for="status_disable"><?php _e('Disable')?></label>
               </div>
           </div>
		</div>

		<div class="mb-4">
			<label class="form-label"><?php _e("Sent to")?></label>
			<div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="send_to" <?php _e( (get_data($result, "send_to")==1 || get_data($result, "send_to") == "")==1?"checked='true'":"" )?> id="send_to_all" value="1">
                        <label class="form-check-label" for="send_to_all"><?php _e('All')?></label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="send_to" <?php _e(get_data($result, "send_to")==2?"checked='true'":"" )?> id="send_to_individual" value="2">
                        <label class="form-check-label" for="send_to_individual"><?php _e('Individual')?></label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="send_to" <?php _e(get_data($result, "send_to")==3?"checked='true'":"" )?> id="send_to_group" value="3">
                        <label class="form-check-label" for="send_to_group"><?php _e('Group')?></label>
                    </div>
                </div>
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
			<?php echo view_cell('\Core\Caption\Controllers\Caption::block', ['value' => get_data($result, "caption")]) ?>

			<ul class="text-gray-400 fs-12">
				<li><?php _e("Random message by Spintax")?></li>
				<li><?php _e("Ex: {Hi|Hello|Hola}")?></li>
			</ul>
			</div>
			<?php echo view_cell('\Core\Whatsapp_button_template\Controllers\Whatsapp_button_template::widget_content', ["result" => $result]) ?>
            <?php echo view_cell('\Core\Whatsapp_list_message_template\Controllers\Whatsapp_list_message_template::widget_content', ["result" => $result]) ?>
		</div>

		<div class="mt-3">
			<div class="card border b-r-6">
				<div class="card-body">
	        		<div class="mb-3">
		                <label for="delay" class="form-label"><?php _e('Resubmit message only after (minute)')?></label>
		                <select class="form-select" id="delay" name="delay">
		                    <?php for ($i=1; $i <= 59; $i++) {?>
		                    	<?php if ( (int)permission("whatsapp_autoresponser_delay") <= $i ): ?>
	                            	<option value="<?php _e($i)?>" <?php _e( !empty($result) && $result->delay == $i ? "selected":"" )?> ><?php _e($i)?></option>
		                    	<?php endif ?>
		                    <?php } ?>


		                    <?php 
		                        for ($i=60; $i <= 3600; $i++) { 
		                            if($i%5 == 0){
		                    ?>
		                    	<?php if ( (int)permission("whatsapp_autoresponser_delay") <= $i ): ?>
		                        <option value="<?php _e($i)?>" <?php _e( !empty($result) && $result->delay == $i ? "selected":"" )?>><?php _e($i)?></option>
		                        <?php endif ?>
		                    <?php
		                            }       
		                        }
		                    ?>
		                </select>
		            </div>

		            <div class="mb-3">
		                <label for="except" class="form-label"><?php _e('Except contacts')?></label>
		                <input type="text" class="form-control form-control-solid" data-role="tagsinput" id="except" name="except" value="<?php _ec( get_data($result, "except") )?>">

		                <span class="text-gray-400 fs-12"><?php _e("Validate exapmle: 841234567890, 840123456789")?></span>
		            </div>
  
				</div>
			</div>
		</div>
	</div>
	<div class="card-footer">
		<div class="d-flex justify-content-end">
			<a class="btn btn-primary btn-hover-scale actionMultiItem" href="<?php _ec( get_module_url("save") )?>">
				<i class="fal fa-paper-plane"></i> <?php _e("Submit")?>
			</a>
		</div>
	</div>
</div>

<script type="text/javascript">
$(function(){
	Core.tagsinput();
});
</script>
	
<?php else: ?>
	
	<div class="text-center py-5">
		<div class="fs-70 text-danger">
			<i class="fad fa-exclamation-triangle"></i>
		</div>
		<h3><?php _e("An Unexpected Error Occurred")?></h3>
		<div class="text-gray-700"><?php _e( $message )?></div>
	</div>

<?php endif ?>