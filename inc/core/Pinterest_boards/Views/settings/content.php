<div class="card card-flush m-b-25">
    <div class="card-header">
        <div class="card-title flex-column">
            <h3 class="fw-bolder"><i class="<?php _ec( $config['icon'] )?>" style="color: <?php _ec( $config['color'] )?>;"></i> <?php _e('Pinterest API Configuration')?></h3>
        </div>
    </div>
    <div class="card-body">
        <div class="mb-4">
            <div class="alert alert-dismissible bg-light-primary border border-primary border-dashed d-flex flex-column flex-sm-row w-100 p-25 mb-10">
                <span class="fs-30 me-4 mb-5 mb-sm-0 text-primary">
                    <i class="fad fa-link"></i>
                </span>
                <div class="d-flex flex-column pe-0 pe-sm-10">
                    <h5 class="mb-1"><?php _e("Callback URL:")?></h5>
                    <span class="m-b-0"><?php _ec( base_url($config['id']) )?></span>

                    <h5 class="mb-1 mt-3"><?php _e("Click this link to create Pinterest app:")?></h5>
                    <span class="m-b-0"><a href="https://developers.pinterest.com/apps/connect/" target="_blank" >https://developers.pinterest.com/apps/connect/</a></span>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <div for="pinterest_environment" class="form-label"><?php _e('Accept login to Pinterest via')?></div>
            <label for="pinterest_official"> 
                <div class="form-check form-check-inline">
                    <input type="hidden" name="pinterest_official" value="0">
                    <input class="form-check-input" type="checkbox" name="pinterest_official" id="pinterest_official" value="1" <?php _e( get_option("pinterest_official", 1)?"checked":"" )?>>
                    <label class="form-check-label" for="dashboard"><?php _e("Official")?></label>
                </div>
            </label>

            <label for="pinterest_unofficial"> 
                <div class="form-check form-check-inline">
                    <input type="hidden" name="pinterest_unofficial" value="0">
                    <input class="form-check-input" type="checkbox" name="pinterest_unofficial" id="pinterest_unofficial" value="1" <?php _e( get_option("pinterest_unofficial", 1)?"checked":"" )?>>
                    <label class="form-check-label" for="dashboard"><?php _e("Unofficial")?></label>
                </div>
            </label>
        </div>

        <div class="mb-4">
            <label for="pinterest_environment" class="form-label"><?php _e('Environment for Pinterest API Official')?></label>
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="pinterest_environment" <?php _e( get_option("pinterest_environment", 0)==1?"checked='true'":"" )?> id="pinterest_environment_enable" value="1">
                    <label class="form-check-label" for="pinterest_environment_enable"><?php _e('Live')?></label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="pinterest_environment" <?php _e( get_option("pinterest_environment", 0)==0?"checked='true'":"" )?> id="pinterest_environment_disable" value="0">
                    <label class="form-check-label" for="pinterest_environment_disable"><?php _e('Sandbox')?></label>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="pinterest_app_id" class="form-label"><?php _e('Pinterest app id')?></label>
            <input type="text" class="form-control form-control-solid" id="pinterest_app_id" name="pinterest_app_id" value="<?php _e( get_option("pinterest_app_id", "") )?>">
        </div>
        <div class="mb-3">
            <label for="pinterest_app_secret" class="form-label"><?php _e('Pinterest app secret key')?></label>
            <input type="text" class="form-control form-control-solid" id="pinterest_app_secret" name="pinterest_app_secret" value="<?php _e( get_option("pinterest_app_secret", "") )?>">
        </div>
    </div>
</div>
