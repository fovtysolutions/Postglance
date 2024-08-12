<div class="header bg-white align-items-stretch">
    <div class="container-fluid d-flex align-items-stretch justify-content-between h-100">
        <div class="d-flex justify-content-between flex-lg-grow-1">
            <div class="d-flex align-items-stretch ms-1 ms-lg-3">
                <div class="d-flex align-items-stretch ms-2 ms-lg-3">
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
            <ul class="d-flex nk-btn-group sm">
                <li class="d-none d-md-block" style="padding:.8rem 0.8rem;">
                    <a href="#" class="btn btn-primary" style="background-color:#ff5c35 !important;color:#fff;border:#ff5c35">
                        <span>Get a demo</span>
                    </a>
                </li>
                <li class="d-none d-md-block" style="padding:.8rem .8rem;">
                    <a href="../signup" class="btn btn-primary" style="background-color:#fff !important;color:#ff5c35;border:#ff5c35 1.5px solid!important">
                        <span>Sign up</span>
                    </a>
                </li>
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