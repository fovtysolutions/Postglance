<?php if( !empty($result) ){?>
<div class="d-flex align-items-stretch ms-1 ms-lg-2">
    <div class="d-flex align-items-center">
        <div class="dropdown dropdown-hide-arrow" data-dropdown-spacing="52.5">
            <a href="javascript:void(0);" class="dropdown-toggle d-block position-relative" data-toggle="dropdown" aria-expanded="true">
                <button class="btn btn-success btn-sm b-r-20"><i class="fad fa-users"></i> <?php _e("Teams")?></button>
            </a>
            <div class="dropdown-menu dropdown-menu-right" >
            	<?php foreach ($result as $key => $row): ?>
                	<a class="dropdown-item py-2 actionItem" href="<?php _ec( base_url("auth/team/".$row->ids) )?>" data-redirect=""><i class="fad fa-users me-2 text-success"></i> <?php _e( sprintf(__("%s Team"), $row->fullname) )?></a>
	  			<?php endforeach ?>
                <li><hr class="border-bottom"></li>
                <a class="dropdown-item actionItem py-2" href="<?php _e( base_url("auth/team") )?>" data-redirect=""><i class="fas fa-user text-success"></i> <?php _e("My account")?></a>
            </div>
        </div>
    </div>
</div>
<?php }?> 