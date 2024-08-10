<div class=" header">
		
		<div class="container">

			<nav class="navbar navbar-expand-lg navbar-light px-0 py-3">
				<div class="logo me-4">
					<a  href="<?php _ec( base_url() )?>"><img class="img-fluid logo" src="<?php _ec( get_option("website_logo_color", base_url("assets/img/logo-color.svg")) )?>" alt="logo"></a>
				</div>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav me-auto mb-2 mb-lg-0">
						<li class="nav-item">
							<a class="nav-link" href="<?php _ec( base_url() )?>"><?php _e("Home")?></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="<?php _ec( uri("segment", 1) == ""?"":base_url() )?>#feature"><?php _e("Features")?></a>
						</li>
						<?php if (find_modules("payment")): ?>
						<li class="nav-item">
							<a class="nav-link" href="<?php _ec( base_url("pricing") )?>"><?php _e("Pricing")?></a>
						</li>
						<?php endif ?>
						<li class="nav-item">
							<a class="nav-link" href="<?php _ec( uri("segment", 1) == ""?"":base_url() )?>#faqs"><?php _e("FAQs")?></a>
						</li>
						<?php if (find_modules("blog_manager")): ?>
						<li class="nav-item">
							<a class="nav-link" href="<?php _ec( base_url("blogs") )?>"><?php _e("Blogs")?></a>
						</li>
						<?php endif ?>
					</ul>

					<?php $lang_data = load_language();?>
	              	<?php if (!empty($lang_data) && isset($lang_data['result']) && !empty($lang_data['result'])): ?>
	              	<?php
		                $result = $lang_data['result'];
		                $default = $lang_data['default'];
	              	?>

		              	<div class="d-flex align-items-stretch me-2 px-3">
		                  <div class="d-flex align-items-center">
		                      	<div class="dropdown dropdown-hide-arrow" data-dropdown-spacing="40">
		                          	<a class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
    									<i class="<?php _ec( $default->icon )?>"></i> <span class="d-xs-inline-block d-sm-inline-block d-md-none d-inline-block"><?php _ec($default->name)?></span>
								  	</a>
								  	<ul class="dropdown-menu mh-200 overflow-auto">
								  		<?php foreach ($result as $key => $value): ?>
								    		<li><a class="dropdown-item py-2 actionItem" href="<?php _ec( base_url("auth/language/".$value->ids) )?>" data-redirect=""><i class="<?php _ec($value->icon)?>"></i> <?php _ec($value->name)?></a></li>
								    	<?php endforeach ?>
								  	</ul>
		                      	</div>
		                  </div>
		              	</div>
	              	<?php endif ?>

					<div class="nav-btn-login me-3 py-3">
						<?php if ( get_session("uid") ): ?>
			                <a href="<?php _ec( base_url("dashboard") )?>" class="btn btn-primary"><?php _e("Dashboard")?></a> 
	              		<?php else: ?>
		                	<?php if ( get_option("signup_status", 1) ): ?>
		                		<a href="<?php _ec( base_url("signup") )?>" class="btn btn-outline-dark me-3"><?php _e("Sign Up")?></a>
		                		<a href="<?php _ec( base_url("login") )?>" class="btn  btn-primary"><?php _e("Log In")?></a>
		                	<?php else: ?>
			                	<a href="<?php _ec( base_url("login") )?>" class="btn  btn-primary"><?php _e("Log In")?></a>
		                	<?php endif ?>
		              	<?php endif ?>
					</div>
				</div>
			</nav>
		</div>

	</div>
