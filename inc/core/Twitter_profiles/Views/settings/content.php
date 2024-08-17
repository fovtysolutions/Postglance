<div class="card card-flush m-b-25">
    <div class="card-header">
        <div class="card-title flex-column">
            <h3 class="fw-bolder"><i class="<?php _ec( $config['icon'] )?>" style="color: <?php _ec( $config['color'] )?>;"></i> <?php _e('Twitter API Configuration')?></h3>
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

        <div class="mb-4">
            <label for="twitter_official_status" class="form-label"><?php _ec("Twitter API Official")?></label>
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="twitter_official_status" id="twitter_official_status_enable" <?php _e( get_option('twitter_official_status', 1)  == 1?"checked":"" )?> value="1">
                    <label class="form-check-label" for="twitter_status_enable"><?php _e("Enable")?></label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="twitter_official_status" id="twitter_official_status_disable" <?php _e( get_option('twitter_official_status', 1)  == 0?"checked":"" )?> value="0">
                    <label class="form-check-label" for="twitter_official_status_disable"><?php _e("Disable")?></label>
                </div>
            </div>
        </div>
        <div class="mb-4">
            <label for="twitter_cookie_status" class="form-label"><?php _ec("Twitter Cookies API")?></label>
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="twitter_cookie_status" id="twitter_cookie_status_enable" <?php _e( get_option('twitter_cookie_status', 1)  == 1?"checked":"" )?> value="1">
                    <label class="form-check-label" for="twitter_status_enable"><?php _e("Enable")?></label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="twitter_cookie_status" id="twitter_cookie_status_disable" <?php _e( get_option('twitter_cookie_status', 1)  == 0?"checked":"" )?> value="0">
                    <label class="form-check-label" for="twitter_cookie_status_disable"><?php _e("Disable")?></label>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="twitter_client_id" class="form-label"><?php _e('Twitter client id')?></label>
            <input type="text" class="form-control form-control-solid" id="twitter_client_id" name="twitter_client_id" value="<?php _e( get_option("twitter_client_id", "") )?>">
        </div>
        <div class="mb-3">
            <label for="twitter_client_secret" class="form-label"><?php _e('Twitter client secret')?></label>
            <input type="text" class="form-control form-control-solid" id="twitter_client_secret" name="twitter_client_secret" value="<?php _e( get_option("twitter_client_secret", "") )?>">
        </div>

        <div class="mb-3">
            <label for="twitter_consumer_key" class="form-label"><?php _e('Twitter consumer id')?></label>
            <input type="text" class="form-control form-control-solid" id="twitter_consumer_key" name="twitter_consumer_key" value="<?php _e( get_option("twitter_consumer_key", "") )?>">
        </div>
        <div class="mb-3">
            <label for="twitter_consumer_secret" class="form-label"><?php _e('Twitter consumer secret')?></label>
            <input type="text" class="form-control form-control-solid" id="twitter_consumer_secret" name="twitter_consumer_secret" value="<?php _e( get_option("twitter_consumer_secret", "") )?>">
        </div>
        <div class="mb-3">
            <label for="twitter_bearer_token" class="form-label"><?php _e('Bearer Token')?></label>
            <input type="text" class="form-control form-control-solid" id="twitter_bearer_token" name="twitter_bearer_token" value="<?php _e( get_option("twitter_bearer_token", "") )?>">
        </div>
    </div>
</div>
