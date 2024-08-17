<div class="card card-flush m-b-25">
    <div class="card-header">
        <div class="card-title flex-column">
            <h3 class="fw-bolder"><i class="<?php _ec( $config['icon'] )?>" style="color: <?php _ec( $config['color'] )?>;"></i> <?php _e('WhatsApp API Configuration')?></h3>
        </div>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label for="whatsapp_server_url" class="form-label"><?php _e('WhatsApp Server URL')?></label>
            <input type="text" class="form-control form-control-solid" id="whatsapp_server_url" name="whatsapp_server_url" value="<?php _e( get_option("whatsapp_server_url", "") )?>" placeholder="https://example.com/">
        </div>
    </div>
</div>
