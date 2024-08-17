<div class="container mw-700 py-5">
    <div class="w-100 m-r-0 d-flex align-items-center justify-content-between">
        <h3 class="fw-bolder m-b-0 text-gray-800"><i class="<?php _ec( $config['icon'] )?>" style="color: <?php _ec( $config['color'] )?>;"></i> <?php _e("Twitter OAuth")?></h3>
    </div>

    <?php if ( get_option("twitter_official_status", 1) && get_option("twitter_cookie_status", 1) ): ?>
    <ul class="nav nav-pills mb-5 m-t-40 bg-light-dark rounded" id="pills-tab">
        <li class="nav-item me-0 wp-50">
            <button class="nav-link bg-active-dark text-active-white text-gray-700 px-4 py-3 w-100 active" data-bs-toggle="pill" data-bs-target="#oauth_tab_1" type="button" role="tab"><?php _e("Official")?></button>
        </li>
        <li class="nav-item me-0 wp-50">
            <button class="nav-link bg-active-dark text-active-white text-gray-700 px-4 py-3 w-100" data-bs-toggle="pill" data-bs-target="#oauth_tab_2" type="button" role="tab"><?php _e("Cookie")?></button>
        </li>
    </ul>
    <?php endif ?>

    <div class="tab-content" id="tab_plans">
        <?php if ( get_option("twitter_official_status", 1) ): ?>
        <div class="tab-pane fade active show  mt-5" id="oauth_tab_1" role="tabpanel">
            <a class="btn w-100 me-2 text-white" style="background-color: <?php _ec( $config['color'] )?>;" href="<?php _ec($oauth_link)?>">
                <i class="<?php _ec( $config['icon'] )?>"></i> 
                <?php _e("Connect with Twitter")?>
            </a>
        </div>
        <?php endif ?>

        <?php if ( get_option("twitter_cookie_status", 1) ): ?>
        <div class="tab-pane fade <?php _ec( (!get_option("twitter_official_status", 1))?"active show mt-5":"" )?> " id="oauth_tab_2" role="tabpanel">
            <form class="actionForm" action="<?php _ec( get_module_url("oauth_cookies") )?>" method="POST" data-redirect="<?php _ec( get_module_url("index/cookie") )?>">
                <div class="card b-r-10">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="twitter_csrf_token" class="form-label"><?php _e('Twitter Csrf Token')?></label>
                            <input type="text" class="form-control form-control-solid" id="twitter_csrf_token" name="twitter_csrf_token">
                        </div>
                        <div class="mb-3">
                            <label for="twitter_auth_token" class="form-label"><?php _e('Twitter Auth Token')?></label>
                            <input type="text" class="form-control form-control-solid" id="twitter_auth_token" name="twitter_auth_token">
                        </div>
                        <div class="mb-3 d-none">
                            <label for="twitter_session" class="form-label"><?php _e('Twitter Session')?></label>
                            <input type="text" class="form-control form-control-solid" id="twitter_session" name="twitter_session" value="token">
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <a class="btn btn-light btn-active-light-primary me-2" href="<?php _ec( base_url("account_manager") )?>"><?php _e("Discard")?></a>
                        <button type="submit" class="btn btn-primary"><?php _e("Submit")?></button>
                    </div>
                </div>
            </form>    

            <div class="card mt-4">
                <div class="card-header cursor-pointer">
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0"><i class="fad fa-question-circle text-primary"></i> <?php _e("How to use")?></h3>
                    </div>
                </div>
                <div class="card-body p-0">
                    <video width="100%" height="370" controls autoplay muted>
                        <source src="<?php _ec( get_module_path( __DIR__ , 'Assets/video.mp4') )?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>

            </div>     
        </div>
        <?php endif ?>
    </div>
</div>