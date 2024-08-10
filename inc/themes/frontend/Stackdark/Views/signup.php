<div class="login container m-b-100 border-top">
	
	<div class="mw-1000 shadow mx-auto b-r-20 bg-gray-100">
		<form class="actionForm" action="<?php _ec( base_url("auth/signup") )?>" data-redirect="<?php _ec( base_url("login") )?>" method="POST">
			<div class="row no-gutters">
				<div class="col-md-6">
					
					<div class="p-50">
						<div class="headline mb-4">
							<h2 class="fs-25 fw-6 mb-0"><?php _e("Signup")?></h2>
							<div class="text-gray-600"><?php _e("Let's get your account set up")?></div>
						</div>

						<div class="mb-3">
							<input type="text" name="fullname" class="form-control h-45 b-r-6 border-gray-200" value="" placeholder="<?php _e("Fullname")?>">
						</div>

						<div class="mb-3">
							<input type="text" name="username" class="form-control h-45 b-r-6 border-gray-200" value="" placeholder="<?php _e("Username")?>">
						</div>

						<div class="mb-3">
							<input type="text" name="email" class="form-control h-45 b-r-6 border-gray-200" value="" placeholder="<?php _e("Email")?>">
						</div>

						<div class="mb-3">
							<input type="password" name="password" class="form-control h-45 b-r-6 border-gray-200" value="" placeholder="<?php _e("Password")?>">
						</div>

						<div class="mb-3">
							<input type="password" name="confirm_password" class="form-control h-45 b-r-6 border-gray-200" value="" placeholder="<?php _e("Confirm Password")?>">
						</div>

						<div class="mb-3">
							<select class="form-control h-45 b-r-6 border-gray-200 text-gray-600" name="timezone">
								<option value=""><?php _e("Select timezone")?></option>
								<?php foreach ( tz_list() as $key => $value): ?>
		                    		<option value="<?php _e( $key ) ?>" <?php _e( get_user("timezone")==$key?"selected":"" )?> ><?php _e( $value )?></option>
		                    	<?php endforeach ?>
							</select>
						</div>

						<div class="mb-3">
							<div class="d-flex justify-content-between">
								<div class="form-check">
								  	<input class="form-check-input m-t-5" type="checkbox" value="1" name="agree_terms" id="agree_terms">
								  	<label class="form-check-label" for="remember">
								    	<?php _e("Accept Terms & Conditions")?>
								  	</label>
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


						<div>
							<?php _e("Already have an account?")?> <a href="<?php _ec( base_url("login") )?>"><?php _e("Login")?></a>
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