<div class="card mb-4">
    <div class="card-header">
        <div class="card-title"><?php _e( $config['name'] )?></div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-4">
                    <label for="coinpayments_status" class="form-label"><?php _e('One-time payment status')?></label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="coinpayments_status" <?php _e( get_option("coinpayments_status", 0)==1?"checked='true'":"" )?> id="coinpayments_status_enable" value="1">
                            <label class="form-check-label" for="coinpayments_status_enable"><?php _e('Enable')?></label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="coinpayments_status" <?php _e( get_option("coinpayments_status", 0)==0?"checked='true'":"" )?> id="coinpayments_status_disable" value="0">
                            <label class="form-check-label" for="coinpayments_status_disable"><?php _e('Disable')?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-4">
            <label for="coinpayments_public_coin" class="form-label"><?php _e('Cryptocurrency type')?></label>
            <input type="text" class="form-control form-control-solid" id="coinpayments_public_coin" name="coinpayments_public_coin" value="<?php _ec( get_option("coinpayments_public_coin", "BTC") )?>">
        </div>
        <div class="mb-4">
            <label for="coinpayments_public_key" class="form-label"><?php _e('Public key')?></label>
            <input type="text" class="form-control form-control-solid" id="coinpayments_public_key" name="coinpayments_public_key" value="<?php _ec( get_option("coinpayments_public_key", "") )?>">
        </div>
        <div class="mb-4">
            <label for="coinpayments_private_key" class="form-label"><?php _e('Client Secret Key')?></label>
            <input type="text" class="form-control form-control-solid" id="coinpayments_private_key" name="coinpayments_private_key" value="<?php _ec( get_option("coinpayments_private_key", "") )?>">
        </div>

        <div class="alert alert-primary">
            <span class="fw-6"><?php _e("IPN URL:")?></span> 
            <a href="<?php _ec( base_url("coinpayments/ipn") )?>" target="_blank"><?php _ec( base_url("coinpayments/ipn") )?></a> 
        </div>
        <div class="mb-4">
            <label for="coinpayments_merchant_id" class="form-label"><?php _e('Your Merchant ID')?></label>
            <input type="text" class="form-control form-control-solid" id="coinpayments_merchant_id" name="coinpayments_merchant_id" value="<?php _ec( get_option("coinpayments_merchant_id", "") )?>">
        </div>
        <div class="mb-4">
            <label for="coinpayments_ipn_secrect" class="form-label"><?php _e('IPN Secret Key')?></label>
            <input type="text" class="form-control form-control-solid" id="coinpayments_ipn_secrect" name="coinpayments_ipn_secrect" value="<?php _ec( get_option("coinpayments_ipn_secrect", "") )?>">
        </div>
    </div>
</div>