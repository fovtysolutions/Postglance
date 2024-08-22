<div class="header bg-white align-items-stretch">
    <div class="container-fluid d-flex align-items-stretch justify-content-between h-100">
        <div class="d-flex justify-content-between flex-lg-grow-1">
            <div class="d-flex align-items-stretch">
                <div class="d-flex align-items-stretch">
                    <div class="d-flex align-items-center">
                        <div class="d-lg-none d-md-none d-sm-block d-xs-block d-block">
                            <a href="javascript:void(0);" class="btn btn-light-primary px-3 btn-open-sidebar">
                                <i class="fad fa-bars p-r-0 fs-20"></i>
                            </a>
                        </div>
                        <a href="<?php _ec( base_url("dashboard") )?>">
                            <img alt="Logo" src="<?php _ec( base_url("assets/img/logo-main.png"))?>" class="logo-small h-39"> 
                        </a>
                    </div>
                </div>
                <div class="d-flex align-items-stretch ms-2 ms-lg-3">
                    <div class="d-flex align-items-center">
                        <div class="d-lg-none d-md-none d-sm-none d-none">
                            <a href="javascript:void(0);" class="btn btn-light-primary p-l-17 p-r-17 btn-open-sub-sidebar">
                                <i class="fad fa-chevron-right pe-0"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="nk-header-action">
            <ul class="d-flex nk-btn-group sm align-items-center" style="column-gap:1.5rem;">
                <!-- <li class="d-none d-md-block" style="padding:.8rem 0rem;">
                    <a href="#" class="btn btn-primary" style="background-color:#ff5c35 !important;color:#fff;border:#ff5c35">
                        <span>Pricing</span>
                    </a>
                </li> -->
                <!-- <li class="d-none d-md-block" style="padding:.8rem 0rem;">
                    <a href="../signup" class="btn btn-primary" style="background-color:#fff !important;color:#ff5c35;border:#ff5c35 1.5px solid!important">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-graph-up-arrow me-2" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M0 0h1v15h15v1H0zm10 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4.9l-3.613 4.417a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61L13.445 4H10.5a.5.5 0 0 1-.5-.5"/>
                    </svg>
                        <span>Upgrade Now</span>
                    </a>
                </li> -->
                <!-- <li class="d-none d-md-block" style="padding:.0rem .8rem 0rem 0rem">
               
                <svg id="notificationIcon" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#ff5c35" class="bi bi-bell dropdown dropdown-hide-arrow" viewBox="0 0 16 16">
                <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2M8 1.918l-.797.161A4 4 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4 4 0 0 0-3.203-3.92zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5 5 0 0 1 13 6c0 .88.32 4.2 1.22 6"/>
                </svg>
                <div id="notificationCard" class="notification-card">
                    <h3>Notification Title</h3>
                    <p>This is the notification card content.</p>
                </div>
                </li> -->
            </ul>
        </div>
        <div class="d-flex align-items-stretch flex-shrink-0 me-1 me-lg-3">
            <?php
                $request = \Config\Services::request();
                $topbars = $request->topbars;
            ?>

            <?php if ( !empty($topbars) ): ?>
                
                <?php foreach ($topbars as $key => $value): ?>
                    <?php _ec( $value['topbar'] )?>
                <?php endforeach ?>

            <?php endif ?>
        </div>
    </div>
</div>
<script>
    // script.js
// script.js
document.addEventListener('DOMContentLoaded', () => {
    const notificationIcon = document.getElementById('notificationIcon');
    const notificationCard = document.getElementById('notificationCard');

    // Toggle visibility of the notification card
    notificationIcon.addEventListener('click', (event) => {
        event.stopPropagation(); // Prevent click event from propagating to the body
        if (notificationCard.style.display === 'none' || notificationCard.style.display === '') {
            notificationCard.style.display = 'block';
        } else {
            notificationCard.style.display = 'none';
        }
    });

    // Hide the notification card when clicking outside
    document.addEventListener('click', (event) => {
        if (!notificationCard.contains(event.target) && !notificationIcon.contains(event.target)) {
            notificationCard.style.display = 'none';
        }
    });
});


</script>