<div class="card card-flush m-b-25">
    <div class="card-header">
        <div class="card-title flex-column">
            <h3 class="fw-bolder"><i class="<?php _ec( $config['icon'] )?>" style="color: <?php _ec( $config['color'] )?>;"></i>  <?php _e($config['name'])?></h3>
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
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label for="gmb_api_key" class="form-label"><?php _e('Google API Key')?></label>
            <input type="text" class="form-control form-control-solid" id="gmb_api_key" name="gmb_api_key" value="<?php _e( get_option("gmb_api_key", "") )?>">
        </div>
        <div class="mb-3">
            <label for="gmb_client_id" class="form-label"><?php _e('Google Client ID')?></label>
            <input type="text" class="form-control form-control-solid" id="gmb_client_id" name="gmb_client_id" value="<?php _e( get_option("gmb_client_id", "") )?>">
        </div>
        <div class="mb-3">
            <label for="gmb_api_secret" class="form-label"><?php _e('Google Client Secret')?></label>
            <input type="text" class="form-control form-control-solid" id="gmb_api_secret" name="gmb_api_secret" value="<?php _e( get_option("gmb_api_secret", "") )?>">
        </div>
    </div>
</div>