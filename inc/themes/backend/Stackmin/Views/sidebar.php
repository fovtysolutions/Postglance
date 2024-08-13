<div class="sidebar-wrapper" style="width:63px;">
    <div class="sidebar d-flex flex-column align-items-lg-center flex-row-auto h-100" >
        <div class="sidebar-logo d-flex flex-column align-items-center flex-column-auto pt-0">
            <a href="<?php _ec( base_url("dashboard") )?>">
                <!-- <img alt="Logo" src="<?php _ec( get_option("website_logo_color", base_url("assets/img/logo-color.svg")) )?>" class="logo-big h-39"> -->
                <!-- <img alt="Logo" src="<?php _ec( base_url("assets/img/logo-post.png"))?>" class="logo-small h-39"> -->

            </a>
        </div>

        <div class="sidebar-nav sidebar-nav-one d-flex flex-column flex-column-fluid w-100 pt-lg-0 hide-x-scroll">
            <ul class="nav flex-column">
                <?php 
                $request = \Config\Services::request();
                $top_sidebar = $request->top_sidebar; 
                ?>

                <!-- <li class="nav-item mb-2">
                    <a href="#" class="nav-link d-flex p-b-12">
                        <i class="bi bi-speedometer2 icon-color"></i>
                    </a>
                </li> -->

                <?php foreach ($top_sidebar as $key => $menus): ?>
                    <?php foreach ($menus as $key => $row): ?>
                        <?php if( ! isset( $row['sub_menu'] ) ){?>
                            <li class="nav-item mb-3">
                                <a href="<?php _e( base_url( $row['id'] ) )?>" style="padding:0px" class="nav-link d-flex p-t-12 p-b-8 <?php _e( uri('segment', 1) == $row['id']?'active text-primary':'hoverable' )?>" <?php _ec( ( get_option("sidebar_type", "sidebar-small") == "sidebar-close"  )?'title="'.$row['name'].'" data-toggle="tooltip" data-placement="right"':'' )?> >
                                    <i class="<?php _e( $row['icon'] )?> icon-color fs-20"  ></i>
                                </a>
                            </li>
                        <?php }else{?>
                            
                        <?php }?>
                    <?php endforeach ?>
                <?php endforeach ?>
            </ul>
        </div>
     

        <div class="sidebar-footer d-flex flex-column-fluid mt-auto w-100 hide-x-scroll">
            <div class="nav flex-column overflow-hidden w-100">
            <?php 
                $bottom_sidebar = $request->bottom_sidebar; 
                ?>

                <?php foreach ($bottom_sidebar as $key => $menus): ?>

                    <?php foreach ($menus as $key => $row): ?>
                        
                        <?php if( ! isset( $row['sub_menu'] ) ){?>
                            <div class="nav-item mb-3">
                                <a href="<?php _e( base_url( $row['id'] ) )?>" style="padding:0px" class="nav-link d-flex p-t-12 p-b-12 <?php _e( uri('segment', 1) == $row['id']?'active text-primary bg-light':'hoverable' )?>" <?php _ec( ( get_option("sidebar_type", "sidebar-small") == "sidebar-close"  )?'title="'.$row['name'].'" data-toggle="tooltip" data-placement="right"':'' )?>>
                                    <i class="<?php _e( $row['icon'] )?> icon-color fs-20"></i>
                                </a>
                            </div>
                        <?php }else{?>

                        <?php }?>

                    <?php endforeach ?>
                    <div class="menu-separator"></div>
                <?php endforeach ?>
            </div>
        </div>

        <!-- <a href="javascript:void(0);" class="sidebar-toggle">
            <div class="btn btn-sm btn-icon btn-white btn-active-primary position-absolute translate-middle start-100 end-0 bottom-0 shadow-sm d-none d-lg-flex">
                <i class="fad fa-chevron-right"></i>
            </div>
        </a> -->
    </div>
</div>
<!--end::Sidebar-->