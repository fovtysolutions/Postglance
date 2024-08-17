<div class="container mw-700 py-5">
    <div class="w-100 m-r-0 d-flex align-items-center justify-content-between">
        <h3 class="fw-bolder m-b-0 text-gray-800"><i class="<?php _ec( $config['icon'] )?>" style="color: <?php _ec( $config['color'] )?>;"></i> <?php _e("Pinterest OAuth")?></h3>
    </div>

    <?php if ( get_option("pinterest_official", 1) && get_option("pinterest_unofficial", 1) ): ?>
    <ul class="nav nav-pills mb-5 m-t-40 bg-light-dark rounded" id="pills-tab">
        <li class="nav-item me-0 wp-50">
            <button class="nav-link bg-active-dark text-active-white text-gray-700 px-4 py-3 w-100 active" data-bs-toggle="pill" data-bs-target="#oauth_tab_1" type="button" role="tab"><?php _e("Official")?></button>
        </li>
        <li class="nav-item me-0 wp-50">
            <button class="nav-link bg-active-dark text-active-white text-gray-700 px-4 py-3 w-100" data-bs-toggle="pill" data-bs-target="#oauth_tab_2" type="button" role="tab"><?php _e("Unofficial")?></button>
        </li>
    </ul>
    <?php endif ?>

    <div class="tab-content" id="tab_plans">
        <?php if ( get_option("pinterest_official", 1) ): ?>
        <div class="tab-pane fade active show  mt-5" id="oauth_tab_1" role="tabpanel">
            <a class="btn btn-danger w-100 me-2" href="<?php _ec($oauth_link)?>">
                <i class="<?php _ec( $config['icon'] )?>"></i> 
                <?php _e("Connect with Pinterest")?>
            </a>
        </div>
        <?php endif ?>

        <?php if ( get_option("pinterest_unofficial", 1) ): ?>
        <div class="tab-pane fade <?php _ec( (!get_option("pinterest_official", 1))?"active show mt-5":"" )?> " id="oauth_tab_2" role="tabpanel">
            <form class="actionForm" action="<?php _ec( get_module_url("oauth_unofficial") )?>" method="POST" data-redirect="<?php _ec( get_module_url("index/unofficial") )?>">
                <div class="card b-r-10">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="username" class="form-label"><?php _e('Pinterest username or email')?></label>
                            <input type="text" class="form-control form-control-solid" id="username" name="username">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label"><?php _e('Pinterest password')?></label>
                            <input type="password" class="form-control form-control-solid" id="password" name="password">
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <a class="btn btn-light btn-active-light-primary me-2" href="<?php _ec( base_url("account_manager") )?>"><?php _e("Discard")?></a>
                        <button class="btn btn-primary"><?php _e("Submit")?></button>
                    </div>
                </div>
            </form>         
        </div>
        <?php endif ?>
    </div>
</div>