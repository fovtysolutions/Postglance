<?php if (get_option("stripe_recurring_status", 0)): ?>
<div class="col-md-6 mb-4">
    <div class="card card-shadow border b-r-10">
        <a href="<?php _e($url)?>" class="card-body d-flex d-flex align-items-center bg-hover-light-primary btnMakePayment">
            <img src="<?php _e($logo)?>" class="w-60 h-60 border b-r-10 me-3">
            <div class="flex-grow-1">
                <div class="fw-6"><?php _e($title)?></div>
                <div class="text-gray-500 fs-12"><?php _e($desc)?></div>
            </div>
        </a>
    </div>
</div>
<?php endif ?>