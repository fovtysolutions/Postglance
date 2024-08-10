<div class="modal fade" id="addPromptTemplate" tabindex="-1" role="dialog">
  	<div class="modal-dialog modal-dialog-centered">
	    <div class="modal-content">
	    	<form class="actionForm" action="<?php _ec( get_module_url("save_prompt/".uri("segment", 4)) )?>" method="POST" data-call-success="Ai_prompt_templates.saveContent(result);">
	      		<div class="modal-header">
			        <h5 class="modal-title"><i class="fad fa-pen"></i> <?php _e("Update Prompt Templates")?></h5>
			         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		      	</div>
		      	<div class="modal-body shadow-none">
			    	<div class="mb-4">
	                    <label class="form-label"><?php _e("Status")?></label>
	                    <div>
	                        <div class="form-check form-check-inline">
	                            <input class="form-check-input" type="radio" name="status" <?php _ec( (get_data($result, "status") == 1 || get_data($result, "status") == "")?"checked='true'":"" ) ?> id="status_enable" value="1">
	                            <label class="form-check-label" for="status_enable"><?php _e('Enable')?></label>
	                        </div>
	                        <div class="form-check form-check-inline">
	                            <input class="form-check-input" type="radio" name="status" <?php _ec( (get_data($result, "status") == 0 )?"checked='true'":"" ) ?> id="status_disable" value="0">
	                            <label class="form-check-label" for="status_disable"><?php _e('Disable')?></label>
	                        </div>
	                    </div>
	                </div>

			        <div class="mb-3">
			            <label for="desc" class="form-label"><?php _e("Category")?></label>
			            <select class="form-select bg-white border form-select-sm" data-control="select2" name="category" required="">
			            	<option><?php _e("Select category")?></option>
                			<?php foreach ($categories as $key => $category): ?>
                    			<option value="<?php _ec($category->ids)?>" <?php _ec( (!empty($category_item) && get_data($category, "id")==$category_item->id)?"selected":"" ) ?>><?php _e($category->name)?></option>
                    		<?php endforeach ?>
						</select>
			        </div>

			        <div class="mb-3">
			            <label for="desc" class="form-label"><?php _e("Prompt")?></label>
			            <textarea class="h-125 form-control" id="prompt" name="prompt"><?php _ec( get_data($result, "content") )?></textarea>
			        </div>
		      	</div>
		      	<div class="modal-footer d-flex justify-content-between py-3">
		      		<a href="<?php _ec( get_module_url() )?>" class="btn btn-secondary"><?php _e("Back")?></a>
			    	<button type="submit" class="btn btn-primary"><?php _e("Save")?></button>
		      	</div>
	      	</form>
	    </div>
  	</div>
</div>