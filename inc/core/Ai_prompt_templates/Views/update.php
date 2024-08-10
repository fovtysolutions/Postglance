<div class="container my-5">
	<form class="actionForm" action="<?php _ec( get_module_url("save/".uri("segment", 4)) )?>" method="POST" data-redirect="<?php _ec( get_module_url() )?>">
		<div class="card m-b-25 mw-800 m-auto">
		    <div class="card-header">
		        <div class="card-title flex-column">
		            <h3 class="fw-bolder"><i class="<?php _e( $config['icon'] )?>" style="color: <?php _e( $config['color'] )?>;"></i> <?php _e( $config['name'] )?></h3>
		        </div>
		    </div>
		    <div class="card-body">
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
		            <label for="name" class="form-label"><?php _e("Category name")?></label>
		            <input type="text" class="form-control form-control-solid" id="name" name="name" value="<?php _ec( get_data($result, "name") )?>">
		        </div>

		        <div class="mb-3">
		            <label for="desc" class="form-label"><?php _e("Description")?></label>
		            <textarea class="h-125 form-control form-control-solid input-editor" id="desc" name="desc"><?php _ec( get_data($result, "desc") )?></textarea>
		        </div>

		        <div class="mb-3">
		            <label for="icon" class="form-label"><?php _e("Icon")?></label>
		            <input type="text" class="form-control form-control-solid" id="icon" name="icon" value="<?php _ec( get_data($result, "icon") )?>">
		            <span class="small mt-3"><?php _e("Find icon at here:")?> <a href="https://fontawesome.com/v5/search">https://fontawesome.com/v5/search</a></span>
		        </div>
		        
		    </div>
		    <div class="card-footer d-flex justify-content-between">
		    	<a href="<?php _ec( get_module_url() )?>" class="btn btn-secondary"><?php _e("Back")?></a>
		    	<button type="submit" class="btn btn-primary"><?php _e("Save")?></button>
		    </div>
		</div>
	</form>
</div>