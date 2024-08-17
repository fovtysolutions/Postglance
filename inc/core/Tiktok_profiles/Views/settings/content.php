<div class="card card-flush m-b-25">
    <div class="card-header">
        <div class="card-title flex-column">
            <h3 class="fw-bolder"><i class="<?php _ec( $config['icon'] )?>" style="color: <?php _ec( $config['color'] )?>;"></i> <?php _e('Tiktok API Configuration')?></h3>
        </div>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label for="tiktok_server_url" class="form-label"><?php _e('Tiktok Server URL')?></label>
            <input type="text" class="form-control form-control-solid" id="tiktok_server_url" name="tiktok_server_url" value="<?php _e( get_option("tiktok_server_url", "") )?>" placeholder="https://example.com/">
        </div>
    </div>
</div>
