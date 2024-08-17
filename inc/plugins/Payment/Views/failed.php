<div class="payment-wrap w-100 h-100 overflow-auto">
    <div class="m-auto mw-800 py-5 px-4"> 
        <div class="mb-5 w-100">
            <img src="<?php _ec( get_option("website_logo_color", base_url("assets/img/logo-color.svg")) )?>" class="h-45 mb-4">
            <div class="mt-5 text-center">
                <div class="fs-80 text-danger"><i class="fad fa-exclamation-triangle"></i></div>
                <h1 class="text-dark fs-30 text-gray-800"><?php _e("Payment failed")?></h1>
                <div class="text-gray-600 fs-16"><?php _e("We were unable to complete your payment due to an error with the payment processing system. Please update your payment details and try again.")?></div>
                <div class="mt-5">
                    <a href="<?php _ec( base_url() )?>" class="btn btn-dark me-3"><?php _e("Home")?></a>
                    <a href="<?php _ec( base_url("dashboard") )?>" class="btn btn-success"><?php _e("Dashboard")?></a>
                </div>
            </div>
        </div>
    </div>
</div>
