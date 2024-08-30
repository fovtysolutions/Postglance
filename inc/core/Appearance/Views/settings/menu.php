<div class="nav-item custom-hover-effect mb-2">
    <a class="nav-link sp-menu-item actionItem <?php _e( uri('segment', 3) == $config['id']?"active bg-light-primary":"" )?>" href="<?php _e( base_url("settings/index/" . $config['id']) )?>" data-remove-other-active="true" data-active="active" data-result="html" data-content="main-wrapper" data-history="<?php _e( base_url("settings/index/" . $config['id']) )?>">
       
            <i class="<?php _ec( $config['icon'] )?> dashboard-icon me-4"></i>
       
        <span class="text-gray-600 fw-5" style="font-size:14px"><?php _e( $config['name'] )?></span>
    </a>
</div>