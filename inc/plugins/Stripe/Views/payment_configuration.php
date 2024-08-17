<div class="card mb-4">
    <div class="card-header">
        <div class="card-title"><?php _e( $config['name'] )?></div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-4">
                    <label for="stripe_one_time_status" class="form-label"><?php _e('One-time payment status')?></label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="stripe_one_time_status" <?php _e( get_option("stripe_one_time_status", 0)==1?"checked='true'":"" )?> id="stripe_one_time_status_enable" value="1">
                            <label class="form-check-label" for="stripe_one_time_status_enable"><?php _e('Enable')?></label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="stripe_one_time_status" <?php _e( get_option("stripe_one_time_status", 0)==0?"checked='true'":"" )?> id="stripe_one_time_status_disable" value="0">
                            <label class="form-check-label" for="stripe_one_time_status_disable"><?php _e('Disable')?></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-4">
                    <label for="stripe_recurring_status" class="form-label"><?php _e('Recurring payment status')?></label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="stripe_recurring_status" <?php _e( get_option("stripe_recurring_status", 0)==1?"checked='true'":"" )?> id="stripe_recurring_status_enable" value="1">
                            <label class="form-check-label" for="stripe_recurring_status_enable"><?php _e('Enable')?></label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="stripe_recurring_status" <?php _e( get_option("stripe_recurring_status", 0)==0?"checked='true'":"" )?> id="stripe_recurring_status_disable" value="0">
                            <label class="form-check-label" for="stripe_recurring_status_disable"><?php _e('Disable')?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <label for="stripe_publishable_key" class="form-label"><?php _e('Publishable key')?></label>
            <input type="text" class="form-control form-control-solid" id="stripe_publishable_key" name="stripe_publishable_key" value="<?php _ec( get_option("stripe_publishable_key", "") )?>">
        </div>
        <div class="mb-4">
            <label for="stripe_secret_key" class="form-label"><?php _e('Secret key')?></label>
            <input type="text" class="form-control form-control-solid" id="stripe_secret_key" name="stripe_secret_key" value="<?php _ec( get_option("stripe_secret_key", "") )?>">
        </div>

        <div class="alert alert-primary">
            <span class="fw-6"><?php _e("Webhook URL:")?></span> 
            <a href="<?php _ec( base_url("stripe_recurring/webhook") )?>" target="_blank"><?php _ec( base_url("stripe_recurring/webhook") )?></a> 
            <br/>
            <span class="fw-6"><?php _e("Required events:")?></span>
            <span class="e"><?php _e('invoice.payment_succeeded, customer.subscription.deleted')?></span>
        </div>

        <div class="mb-4">
            <label for="stripe_webhook_id" class="form-label"><?php _e('Webhook ID')?></label>
            <input type="text" class="form-control form-control-solid" id="stripe_webhook_id" name="stripe_webhook_id" value="<?php _ec( get_option("stripe_webhook_id", "") )?>">
        </div>
    </div>
</div>