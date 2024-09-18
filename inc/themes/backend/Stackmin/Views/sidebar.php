
<head>
    <style>
 
 .custom-border-hover {
    position: relative;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.custom-border-hover:hover {
    background-color: white;
   
}

.custom-border-hover:hover i {
    color: #ff5c35; /* Blue color for the icon */
}
.text{
    color:#ff5c35;
}
.vho{
    margin-top:5px
}

li.nav-item.custom-border-hover:hover .vho {
    color:#ff5c35 !important;
}
a:active .vho {
    color:#ff5c35 !important;
}
    </style>
</head>

<div class="sidebar-wrapper" style="width:63px;">
    <div class="sidebar d-flex flex-column align-items-lg-center flex-row-auto h-100" >
        <div class="sidebar-logo d-flex flex-column align-items-center flex-column-auto pt-0">
            <a href="<?php _ec( base_url("dashboard") )?>">
                <!-- <img alt="Logo" src="<?php _ec( get_option("website_logo_color", base_url("assets/img/logo-color.svg")) )?>" class="logo-big h-39"> -->
                <!-- <img alt="Logo" src="<?php _ec( base_url("assets/img/logo-post.png"))?>" class="logo-small h-39"> -->

            </a>
        </div>

        <div class="sidebar-nav sidebar-nav-one d-flex flex-column flex-column-fluid w-100 pt-lg-0 n-scroll">
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
                            <a href="<?php _e(base_url($row['id'])) ?>">
                                <li class="nav-item custom-border-hover <?php _e(uri('segment', 1) == $row['id'] ? 'bg-light' : '') ?>" style="border-bottom:1px solid rgba(255,255,255, 0.5)">
                                    <p style="padding:0px" class="nav-link d-flex p-t-12 p-b-8 <?php _e(uri('segment', 1) == $row['id'] ? 'active text-primary' : 'hoverable') ?>" <?php _ec(get_option("sidebar_type", "sidebar-small") == "sidebar-close" ? 'title="' . $row['name'] . '" data-toggle="tooltip" data-placement="right"' : '') ?>>
                                    <i class="<?php _e($row['icon']) ?> icon-color fs-20 <?php _e(uri('segment', 1) == $row['id'] ? 'text' : '') ?>"></i>
                                    <span class="fw-5 vho"><?php _e( $row['name'] )?></span>
                                    </p>
                                </li>
                            </a>
                        <?php }else{?>
                            
                        <?php }?>
                    <?php endforeach ?>
                <?php endforeach ?>
            </ul>
        </div>
     

        <div class="pt-0 sidebar-footer d-flex flex-column-fluid mt-auto w-100 hide-x-scroll" style="margin-bottom:4.5rem">
            <div class="nav flex-column overflow-hidden w-100">
            <?php $bottom_sidebar = $request->bottom_sidebar; ?>
                <?php foreach ($bottom_sidebar as $key => $menus): ?>
                    <?php foreach ($menus as $key => $row): ?>
                        <?php if( ! isset( $row['sub_menu'] ) ){?>
                            <a href="<?php _e( base_url( $row['id'] ) )?>">
                            <li class="nav-item custom-border-hover <?php _e(uri('segment', 1) == $row['id'] ? 'bg-light' : '') ?>" style="border-bottom:1px solid rgba(255,255,255, 0.5)">
                                <p  style="padding:0px" class="nav-link d-flex p-t-12 p-b-8 <?php _e( uri('segment', 1) == $row['id']?'active text-primary':'hoverable' )?>" <?php _ec( ( get_option("sidebar_type", "sidebar-small") == "sidebar-close"  )?'title="'.$row['name'].'" data-toggle="tooltip" data-placement="right"':'' )?>>
                                    <i class="<?php _e($row['icon']) ?> icon-color fs-20 <?php _e(uri('segment', 1) == $row['id'] ? 'text' : '') ?>"></i>
                                    <span class="vho fw-5"><?php _e( $row['name'] )?></span>
                                </p>
                                </li>
                                </a>
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