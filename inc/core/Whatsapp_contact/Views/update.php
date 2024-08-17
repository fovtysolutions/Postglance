<form class="actionForm" action="<?php _eC( get_module_url("save/".get_data($result, "ids")) )?>" method="POST" data-redirect="<?php _ec( get_module_url() )?>">
    <div class="container my-5 mw-800">
        <div class="bd-search position-relative me-auto">
            <h2 class="mb-0 py-4"> <i class="<?php _ec( $config['icon'] )?> me-2" style="color: <?php _ec( $config['color'] )?>;"></i> <?php _e( $config['name'] )?></h2>
        </div>

        <div class="card b-r-6 h-100 post-schedule wrap-caption">
            <div class="card-header">
                <h3 class="card-title"><?php _e("Update")?></h3>
                <div class="card-toolbar"></div>
            </div>
            <div class="card-body position-relative">
                <div class="mb-4">
                    <label class="form-label"><?php _e("Status")?></label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" <?php _e(get_data($result, "status")==1 || get_data($result, "status") == ""?"checked='true'":"" )?> id="status_enable" value="1">
                            <label class="form-check-label" for="status_enable"><?php _e('Enable')?></label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" <?php _e( get_data($result, "status", "radio", 0) )?> id="status_disable" value="0">
                            <label class="form-check-label" for="status_disable"><?php _e('Disable')?></label>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label"><?php _e("Group contact name")?></label>
                    <input type="text" class="form-control form-control-solid" name="name" value="<?php _ec( get_data($result, "name") )?>" required>
                </div>
                
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-between">
                    <a href="<?php _ec( get_module_url() )?>" class="btn btn-dark btn-hover-scale">
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