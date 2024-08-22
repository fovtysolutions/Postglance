
<head>
    <style>
       .button-wrapper {
    display: inline-flex;
    align-items: center;
}

.slide-text {
    margin-left: 0; /* Start without space */
    max-width: 0; /* Start with zero width */
    overflow: hidden;
    white-space: nowrap;
    transition: all 0.4s ease-in-out;
    opacity: 0;
    visibility: hidden;
}

.button-wrapper:hover .slide-text {
    margin-left: 10px; /* Add space between button and text */
    max-width: 200px; /* Set the max-width to fit the content */
    opacity: 1;
    visibility: visible;
}
#upgrade {
    position: relative;
    z-index: 1; /* Ensure the button stays above the text */
}
    </style>
</head>
<div class="d-flex align-items-stretch ms-3" style="column-gap:1.5rem;">
<div class="d-flex align-items-center">
                    <a href="#" class="btn btn-light-primary btn-sm w-100 fm-open-new-folder">
                    <?php _e("AI Composer") ?>
                    </a>
</div>

    <?php
    $expiration_date = get_user("expiration_date");
    ?>
<div class="button-wrapper d-flex align-items-center">
<div class="slide-text">
        <?php if ($expiration_date > time()): ?>
            <div class="d-flex align-items-center me-2">
                <span><?php _ec(sprintf(__("Expire date: %s"), date_show(get_user("expiration_date")))) ?></span>
            </div>
        <?php else: ?>
            <?php if ($expiration_date == 0): ?>
                <div class="d-flex align-items-center me-2">
                    <span><?php _e(sprintf(__("Expire date: %s"), __("Unlimited"))) ?></span>
                </div>
            <?php else: ?>
                <div class="d-flex align-items-center me-2 text-danger">
                    <span><?php _ec("Subscription has expired") ?></span>
                </div>
            <?php endif ?>
        <?php endif ?>
    </div>
    <a id="upgrade" href="https://app2.postglance.com/pricing" class="btn btn-primary btn-sm">
    <i class="bi bi-graph-up-arrow"></i>
        <?php _e("Upgrade") ?>
    </a>   
</div>
             <div class="d-flex align-items-center">              
                <svg id="notificationIcon" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#ff5c35" class="bi bi-bell dropdown dropdown-hide-arrow" viewBox="0 0 16 16">
                <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2M8 1.918l-.797.161A4 4 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4 4 0 0 0-3.203-3.92zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5 5 0 0 1 13 6c0 .88.32 4.2 1.22 6"/>
                </svg>
                <div id="notificationCard" class="notification-card">
                    <h3>Notification Title</h3>
                    <p>This is the notification card content.</p>
                </div>
                </div>


</div>
