<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-7">
            <form class="actionForm" action="<?php _ec( get_module_url("token") )?>" method="POST" data-redirect="<?php _ec( get_module_url() )?>">
                <div class="card mb-4 mb-xl-10">
                    <div class="card-header cursor-pointer">
                        <div class="card-title m-0">
                            <h3 class="fw-bold m-0"><i class="<?php _ec( $config['icon'] )?>" style="color: <?php _ec($config['color'])?>"></i> <?php _e("Get Vk access token")?></h3>
                        </div>
                    </div>
                    <div class="card-body p-25">
                        <div class="mb-4">
                            <a class="btn btn-light btn-light-primary w-100 me-2" href="<?php _ec($oauth_link)?>" target="_blank"><i class="fad fa-external-link-alt"></i> <?php _e("Get Vk code")?></a>
                        </div>
                        <div class="mb-3">
                            <label for="code" class="form-label"><?php _e('Enter vk code')?></label>
                            <input type="text" class="form-control form-control-solid" id="code" name="code">
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <a class="btn btn-light btn-active-light-primary me-2" href="<?php _ec( base_url("account_manager") )?>"><?php _e("Discard")?></a>
                        <button class="btn btn-primary"><?php _e("Submit")?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>