<?php if ($status == "success"): ?>
	
	<div class="d-md-flex align-items-center mb-4">
		<div class="w-100 d-flex align-items-center me-3 mb-3">
			<div class="w-70 h-70">
				<img src="<?php _ec( get_file_url($account->avatar) )?>" class="w-100 border b-r-10">
			</div>
			<div class="ms-3">
				<h3><?php _ec( $account->name )?></h3>
				<div><?php _ec( $account->pid )?></div>
			</div>
		</div>
		<div class="mb-3">
			<?php if ($account->status == 1): ?>
				<a href="<?php _ec( base_url("whatsapp/logout/".$account->ids) )?>" class="btn btn-light-danger btn-sm border w-100 b-r-10 actionItem text-nowrap" data-redirect=""><i class="fad fa-sign-out"></i> <?php _e("Logout")?></a>
			<?php else: ?>
				<a href="<?php _ec( base_url("whatsapp_profiles/oauth/".$account->token) )?>" class="btn btn-light-primary btn-sm border w-100 b-r-10 text-nowrap"><i class="fad fa-sign-in"></i> <?php _e("Re-login")?></a>
			<?php endif ?>
		</div>
	</div>

	<ul class="list-group list-group-flush b-r-10">
	  	<li class="list-group-item px-4 py-4">
	  		<div class="fw-6"><?php _e("Instance ID")?></div>
	  		<div class="bg-light-dark  b-r-6 p-10"><?php _ec( $account->token )?></div>
	  	</li>
	  	<li class="list-group-item px-4 py-4">
	  		<div class="fw-6"><?php _e("Access Token")?></div>
	  		<div class="bg-light-dark  b-r-6 p-10"><?php _ec( $access_token )?></div>
	  	</li>
	</ul>

	<div class="fs-12 text-gray-400 mt-4 text-end"><?php _e( sprintf("Last update: %s", datetime_show($account->changed)) )?></div>

<?php else: ?>
	
	<?php if (post("account") != ""): ?>
		<div class="text-center">
			<div class="fs-70 text-danger"><i class="fad fa-exclamation-triangle"></i></div>
			<h3><?php _e("An Unexpected Error Occurred")?></h3>
			<div><?php _e($message)?></div>
		</div>
	
	<?php else: ?>
		<?php _ec( $this->include('Core\Whatsapp\Views\empty'), false);?>
	<?php endif ?>

<?php endif ?>