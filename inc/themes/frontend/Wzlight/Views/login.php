<div class="login container m-b-100 border-top">
		
	<div class="mw-1000 shadow mx-auto b-r-20">
		<form class="actionForm" action="<?php _ec( base_url("auth/login") )?>" data-redirect="<?php _ec( base_url("dashboard") )?>" method="POST">
			<div class="row no-gutters">
				<div class="col-md-6 justify-content-center align-items-center">
					<div class="d-flex justify-content-center align-items-center h-100">
						<div class="p-50 w-100">
							<div class="headline mb-4">
								<h2 class="fs-25 fw-6 mb-0"><?php _e("Login")?></h2>
								<div class="text-gray-600"><?php _e("Sign In To Your Account")?></div>
							</div>

							<div class="mb-3">
								<input type="text" name="username" class="form-control h-45 b-r-6 border-gray-200" value="" placeholder="<?php _e("Enter your username or email")?>">
							</div>

							<div class="mb-3">
								<input type="password" name="password" class="form-control h-45 b-r-6 border-gray-200" value="" placeholder="<?php _e("Enter your Password")?>">
							</div>

							<div class="mb-3">
								<div class="d-flex justify-content-between">
									<div class="form-check">
									  	<input class="form-check-input m-t-5" type="checkbox" value="" id="remember">
									  	<label class="form-check-label" for="remember">
									    	<?php _e("Remember me")?>
									  	</label>
									</div>
									<div>
										<a href="<?php _ec( base_url("forgot_password") )?>"><?php _e("Forgot password?")?></a>
									</div>
								</div>
							</div>

							<?php if(get_option('google_recaptcha_status', 0)){?>
							<div class="g-recaptcha  mb-3" data-sitekey="<?=get_option('google_recaptcha_site_key', '')?>"></div>
					    	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
							<?php }?>

							<div class="show-message mb-2"></div>

							<div class="mb-3">
								<button type="submit" class="btn mb-2 btn-dark w-100 mb-md-3 fw-6 text-uppercase fs-16">
									<?php _e("Login")?>
								</button>
							</div>

							<?php if ( get_option('google_login_status', 0) || get_option('facebook_login_status', 0) || get_option('twitter_login_status', 0) ): ?>
							<div class="text-center fw-4 fs-16 mb-3 text-uppercase"><?php _e("Or login with")?></div>

							<div>
								<?php if ( get_option('google_login_status', 0) ): ?>
								<a href="<?php _ec( base_url("login/google") )?>" class="btn mb-2 btn-outline btn-gooogle text-left w-100 mb-md-3">
									<img src="<?php _ec( get_frontend_url() )?>Assets/img/google.png" class="w-16"> <?php _e("Google")?>
								</a>
								<?php endif ?>
								<?php if ( get_option('facebook_login_status', 0) ): ?>
								<a href="<?php _ec( base_url("login/facebook") )?>" class="btn mb-2 btn-fb text-left w-100 mb-md-3">
									<i class="fab fa-facebook-f mr-2"></i> <?php _e("Facebook")?>
								</button>
								<?php endif ?>
								<?php if ( get_option('twitter_login_status', 0) ): ?>
								<a href="<?php _ec( base_url("login/twitter") )?>" class="btn mb-2 btn-twitter text-left w-100 mb-md-3">
									<i class="fab fa-twitter mr-2"></i> <?php _e("Twitter")?>
								</a>
								<?php endif ?>
							</div>
							<?php endif ?>

							<?php if ( get_option("signup_status", 1) ): ?>
							<div class="mb-3 text-right">
								<?php _e("Don't have an account?")?> <a href="<?php _ec( base_url("signup") )?>"><?php _e("Sign Up")?></a>
							</div>
							<?php endif ?>
						</div>
					</div>

				</div>
				<div class="col-md-6 ">
					<?php require_once "slogan.php"; ?>
				</div>

			</div>
		</form>
	</div>
</div>