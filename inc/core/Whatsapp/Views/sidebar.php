<div class="sub-sidebar bg-white d-flex flex-column flex-row-auto">
    <div class="d-flex mb-10 p-20">
        <div class="d-flex align-items-center w-lg-400px">
            <form class="w-100 position-relative ">
                <div class="input-group sp-input-group">
                  <span class="input-group-text bg-light border-0 fs-20 bg-gray-100 text-gray-800" id="sub-menu-search"><i class="fad fa-search"></i></span>
                  <input type="text" class="form-control form-control-solid ps-15 bg-light border-0 search-input" data-search="group-item" name="search" value="" placeholder="<?php _e("Search")?>" autocomplete="off">
                </div>
            </form>
        </div>
    </div>

    <div class="d-flex mb-10 p-l-20 p-r-20 m-b-12">
        <h3 class="text-gray-800 fw-bold"><?php _e( $title )?></h3>
    </div>

    <div class="sp-menu n-scroll sp-menu-two menu menu-column menu-fit menu-rounded menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 p-l-20 p-r-20 m-b-12 fw-5 h-100">
        <?php if ( permission("whatsapp_profiles") ): ?>
            <a href="<?php _ec( base_url("whatsapp_profiles/oauth") )?>" class="btn btn-light-success b-r-6 mb-3">
                <i class="fad fa-plus"></i><?php _e("Add account")?>
            </a>
        <?php endif ?>

        <?php if ( !empty($modules) ): ?>
            
            <?php $count = 0; ?>

            <?php foreach ($modules as $id => $module): ?>

                <?php if (!empty($module)): ?>

                    <?php
                        $have_permission = false;
                    ?>

                    <?php 
                    foreach ($module as $key => $value) {
                        if ( permission($value['config']['id']) ) {
                            $have_permission = true;
                        }
                    }
                    ?>

                    <?php if ($have_permission): ?>
                    <div class="menu-item">
                        <div class="menu-content pb-2 p-b-10">
                            <span class="menu-section text-muted text-uppercase fs-12 ls-1">
                                <?php _e( $module[0]['config']["parent"]["name"] )?>
                            </span>
                        </div>
                    </div>
                    <?php endif ?>

                    <?php foreach ($module as $key => $value): ?>

                        <?php if ( permission($value['config']['id']) ): ?>
                        <a href="<?php _e( base_url($value['config']['id']) )?>" class="sp-menu-item d-flex align-items-center px-2 py-2 rounded bg-hover-light-primary actionItem <?php _e( uri('segment', 1)==$value['config']['id']?'bg-light-primary':'' )?>" data-remove-other-active="true" data-active="bg-light-primary" data-result="html" data-content="main-wrapper" data-call-after="Core.select2();" data-history="<?php _e( base_url($value['config']['id']) )?>">
                            <div class="d-flex mb-10 me-auto w-100 align-items-center">
                                <div class="d-flex align-items-center mb-10 ">
                                    <div class="symbol symbol-40px p-r-10">
                                        <span class="symbol-label border bg-white">
                                            <i class="<?php _ec($value['config']['icon'])?> pe-0 fs-20" style="color: <?php _ec($value['config']['color'])?>"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex flex-column flex-grow-1 text-over">
                                    <h5 class="custom-list-title fw-bold text-gray-800 mb-0 fs-12"><?php _e( $value['config']['name'] )?></h5>
                                    <span class="text-gray-700 fs-10 text-over"><?php _e( $value['config']['desc'] )?></span>
                                </div>
                            </div>
                        </a>
                        <?php endif ?>

                    <?php endforeach ?>

                <?php endif ?>


            <?php endforeach ?>

        <?php endif ?>
    </div>
</div>