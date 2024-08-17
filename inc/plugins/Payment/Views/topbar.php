<div class="d-flex align-items-stretch ms-3">
    <?php
    $expiration_date = get_user("expiration_date");
    ?>

    <?php if ($expiration_date > time()): ?>
        <div class="d-flex align-items-center me-2"><span class="d-lg-block d-md-block d-sm-none d-none"><?php _ec( sprintf( __("Expire date: %s"), date_show( get_user("expiration_date") ) ) )?></span></div>
    <?php else: ?>
        <?php if ($expiration_date == 0): ?>
            <div class="d-flex align-items-center me-2"><span class="d-lg-block d-md-block d-sm-none d-none"><?php _e( sprintf( __("Expire date: %s"), __("Unlimited") ) )?></span></div>
        <?php else: ?>
            <div class="d-flex align-items-center me-2 text-danger"><span class="d-lg-block d-md-block d-sm-none d-none"><?php _ec("Subscription has expired")?></span></div>
        <?php endif ?>
    <?php endif ?>
    <div class="d-flex align-items-center">
        <a href="<?php _ec( base_url("pricing") )?>" class="btn btn-primary btn-sm b-r-20"><?php _e("Upgrade")?></a>
    </div>
</div>