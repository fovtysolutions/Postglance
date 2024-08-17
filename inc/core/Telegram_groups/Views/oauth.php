<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-7">
            <form class="actionForm" action="<?php _ec( get_module_url("token") )?>" method="POST" data-redirect="<?php _ec( get_module_url() )?>">
                <div class="card mb-4 mb-xl-10">
                    <div class="card-header cursor-pointer">
                        <div class="card-title m-0">
                            <h3 class="fw-bold m-0"><i class="<?php _ec( $config['icon'] )?>" style="color: <?php _ec($config['color'])?>"></i> <?php _e("Get Telegram access token")?></h3>
                        </div>
                    </div>
                    <div class="card-body p-25">
                        <div class="mb-4">
                            <a class="btn btn-light btn-light-primary w-100 me-2" href="https://telegram.me/botfather"><i class="fad fa-external-link-alt"></i> <?php _e("Create Telegram bot")?></a>
                        </div>
                        <div class="mb-3">
                            <label for="access_token" class="form-label"><?php _e('Enter access token')?></label>
                            <input type="text" class="form-control form-control-solid" id="access_token" name="access_token">
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <a class="btn btn-light btn-active-light-primary me-2" href="<?php _ec( base_url("account_manager") )?>"><?php _e("Discard")?></a>
                        <button class="btn btn-primary"><?php _e("Submit")?></button>
                    </div>
                </div>
            </form>

            <div class="card">
                <div class="card-header cursor-pointer">
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0"><i class="fad fa-question-circle text-white"></i> <?php _e("How to get access token")?></h3>
                    </div>
                </div>
                <div class="card-body">

                    <div class="d-flex flex-stack">
                        <div class="fs-18 align-items-center me-3 fw-bold text-white bg-dark w-28 h-28 rounded-circle text-center">
                            1
                        </div>
                        <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                            <div class="flex-grow-1 me-2 text-over-all">
                                <?php _e("Click button Create Telegram bot") ?>
                            </div>
                        </div>
                    </div>
                    <div class="separator separator-dashed my-4"></div>
                    <div class="d-flex flex-stack">
                        <div class="fs-18 align-items-center me-3 fw-bold text-white bg-dark w-28 h-28 rounded-circle text-center">
                            2
                        </div>
                        <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                            <div class="flex-grow-1 me-2 text-over-all">
                                <?php _e("Click button Create Telegram bot") ?>
                            </div>
                        </div>
                    </div>
                    <div class="separator separator-dashed my-4"></div>
                    <div class="d-flex flex-stack">
                        <div class="fs-18 align-items-center me-3 fw-bold text-white bg-dark w-28 h-28 rounded-circle text-center">
                            3
                        </div>
                        <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                            <div class="flex-grow-1 me-2 text-over-all">
                                <?php _e("Give the Telegram bot a friendly name.") ?>
                            </div>
                        </div>
                    </div>
                    <div class="separator separator-dashed my-4"></div>
                    <div class="d-flex flex-stack">
                        <div class="fs-18 align-items-center me-3 fw-bold text-white bg-dark w-28 h-28 rounded-circle text-center">
                            4
                        </div>
                        <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                            <div class="flex-grow-1 me-2 text-over-all">
                                <?php _e("Give the Telegram bot a unique username.") ?>
                            </div>
                        </div>
                    </div>
                    <div class="separator separator-dashed my-4"></div>
                    <div class="d-flex flex-stack">
                        <div class="fs-18 align-items-center me-3 fw-bold text-white bg-dark w-28 h-28 rounded-circle text-center">
                            5
                        </div>
                        <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                            <div class="flex-grow-1 me-2 text-over-all">
                                <?php _e("Copy the Telegram bot's access token.") ?>
                            </div>
                        </div>
                    </div>
                    <div class="separator separator-dashed my-4"></div>
                    <div class="d-flex flex-stack">
                        <div class="fs-18 align-items-center me-3 fw-bold text-white bg-dark w-28 h-28 rounded-circle text-center">
                            6
                        </div>
                        <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                            <div class="flex-grow-1 me-2 text-over-all">
                                <?php _e("Enter the Telegram bot's access token") ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>