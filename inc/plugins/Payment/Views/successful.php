<div class="payment-wrap w-100 h-100 overflow-auto">
    <div class="m-auto mw-800 py-5 px-4"> 
        <div class="mb-5 w-100">
            <img src="<?php _ec( get_option("website_logo_color", base_url("assets/img/logo-color.svg")) )?>" class="h-45 mb-4">
            <div class="mt-5 text-center">
                <div class="fs-80 text-success"><i class="fad fa-badge-check"></i></div>
                <h1 class="text-dark fs-30 text-gray-800"><?php _e("Payment successful")?></h1>
                <div class="text-gray-600 fs-16"><?php _e("Congratulations, your payment has been successfully processed! We look forward to working with you more in the future. You can enjoy plan features now!")?></div>
                <div class="mt-5">
                    <a href="<?php _ec( base_url() )?>" class="btn btn-dark me-3"><?php _e("Home")?></a>
                    <a href="<?php _ec( base_url("dashboard") )?>" class="btn btn-success"><?php _e("Dashboard")?></a>
                </div>
            </div>
        </div>
    </div>
</div>
