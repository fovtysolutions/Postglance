<div class="login container m-b-100 border-top">
        
    <div class="mw-1000 shadow mx-auto b-r-20 bg-gray-100">
        <form class="actionForm" action="<?php _ec( base_url("auth/forgot_password") )?>" method="POST">
            <div class="row no-gutters">
                <div class="col-md-6">
                    
                    <div class="p-50 p-t-150 p-b-150">
                        <?php if ($status): ?>
							<div class="">
								<h1 class="text-success"><i class="far fa-check-circle"></i></h1>
								<h5><?php _e("Activation successful")?></h5>
								<p><?php _e("Thank you for choosing us. Sign in and get started.")?></p>
								<a href="<?php _ec( base_url("login") )?>" class="btn btn-primary w-auto"><?php _e("Login")?></a>
							</div>
						<?php else: ?>
							<div class="">
								<h1 class="text-danger"><i class="far fa-frown"></i></h1>
								<h5><?php _e("Activation unsuccessful")?></h5>
								<p><?php _e("Incorrect or invalid activation code")?></p>
								<a href="<?php _ec( base_url("resend_activation") )?>" class="btn btn-primary w-auto"><?php _e("Resend activation email")?></a>
							</div>
						<?php endif ?>
                    </div>

                </div>
                <div class="col-md-6 ">
                    <?php require_once "slogan.php"; ?>
                </div>

            </div>
        </form>
    </div>
</div>