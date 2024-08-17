<div class="card mb-4">
    <div class="card-header">
        <div class="card-title"><?php _e( $config['name'] )?></div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-4">
                    <label for="payment_environment" class="form-label"><?php _e('Environment')?></label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="payment_environment" <?php _e( get_option("payment_environment", 0)==1?"checked='true'":"" )?> id="payment_environment_live" value="1">
                            <label class="form-check-label" for="payment_environment_live"><?php _e('Live')?></label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="payment_environment" <?php _e( get_option("payment_environment", 0)==0?"checked='true'":"" )?> id="payment_environment_sandbox" value="0">
                            <label class="form-check-label" for="payment_environment_sandbox"><?php _e('Sandbox')?></label>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-4">
                    <label for="email_payment_success" class="form-label"><?php _e('Email payment success')?></label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="email_payment_success" <?php _e( get_option("email_payment_success", 0)==1?"checked='true'":"" )?> id="email_payment_success_enable" value="1">
                            <label class="form-check-label" for="email_payment_success_enable"><?php _e('Yes')?></label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="email_payment_success" <?php _e( get_option("email_payment_success", 0)==0?"checked='true'":"" )?> id="email_payment_success_disable" value="0">
                            <label class="form-check-label" for="email_payment_success_disable"><?php _e('No')?></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-4">
                    <label for="email_payment_renewal_reminders" class="form-label"><?php _e('Email payment renewal reminders')?></label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="email_payment_renewal_reminders" <?php _e( get_option("email_payment_renewal_reminders", 0)==1?"checked='true'":"" )?> id="email_payment_renewal_reminders_enable" value="1">
                            <label class="form-check-label" for="email_payment_renewal_reminders_enable"><?php _e('Yes')?></label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="email_payment_renewal_reminders" <?php _e( get_option("email_payment_renewal_reminders", 0)==0?"checked='true'":"" )?> id="email_payment_renewal_reminders_disable" value="0">
                            <label class="form-check-label" for="email_payment_renewal_reminders_disable"><?php _e('No')?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <label for="payment_currency" class="form-label"><?php _e('Currency')?></label>
            <select class="form-control form-control-solid" name="payment_currency">
		        <?php foreach (get_list_currency() as $currency => $name) {?>
		        	<option value="<?php _e( $currency )?>" <?php _e( get_option('payment_currency', 'USD') == $currency?"selected":"" )?> >[<?php _e( $currency )?>] <?php _e( $name )?></option>
		        <?php }?>
	        </select>
        </div>
        <div class="mb-4">
            <label for="payment_symbol" class="form-label"><?php _e('Symbol')?></label>
            <input type="text" class="form-control form-control-solid" id="payment_symbol" name="payment_symbol" value="<?php _ec( get_option("payment_symbol", "$") )?>">
        </div>
    </div>
</div>