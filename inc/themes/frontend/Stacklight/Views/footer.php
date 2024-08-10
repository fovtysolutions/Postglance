<div class="footer">
		<div class="footer-bg"></div>
		<div class="container">
			<div class="footer-top  p-t-50">
				<div class="row">
					<div class="col-md-5 mb-5">
						<div class="p-r-50">
							<div class="mb-4 me-3 h-55">
								<img src="<?php _ec( get_option("website_logo_color", base_url("assets/img/logo-color.svg")) )?>" class="h-100">
							</div>
							<div class="text-gray-600"><?php _e("Helping you execute a comprehensive marketing plan, manage your brands by scheduling your posts to optimize performance on many social media platforms")?></div>
						</div>
					</div>
					<div class="col-md-7">
						<div class="row">
							<div class="col-md-4 mb-5">
								<div class="fw-6 fs-18 text-primary"><?php _e("Quick Links")?></div>
								<ul>
									<li><a class="text-gray-700" href="<?php _ec( base_url() )?>"><?php _e("Home")?></a></li>
									<li><a class="text-gray-700" href="<?php _ec( uri("segment", 1) == ""?"":base_url() )?>#feature"><?php _e("Features")?></a></li>
									<?php if (find_modules("payment")): ?>
									<li><a class="text-gray-700" href="<?php _ec( base_url("pricing") )?>"><?php _e("Pricing")?></a></li>
									<?php endif ?>
									<li><a class="text-gray-700" href="<?php _ec( uri("segment", 1) == ""?"":base_url() )?>#faqs"><?php _e("FAQs")?></a></li>
									<?php if (find_modules("blog_manager")): ?>
									<li><a class="text-gray-700" href="<?php _ec( base_url("blogs") )?>"><?php _e("Blogs")?></a></li>
									<?php endif ?>
								</ul>
							</div>
							<div class="col-md-4 mb-5">
								<div class="fw-6 fs-18 text-primary">Useful Links</div>
								<ul>
									<li><a class="text-gray-700" href="<?php _ec( base_url("login") )?>"><?php _e("Login")?></a></li>
									<li><a class="text-gray-700" href="<?php _ec( base_url("signup") )?>"><?php _e("Signup")?></a></li>
									<li><a class="text-gray-700" href="<?php _ec( base_url("terms_of_service") )?>"><?php _e("Terms of Service")?></a></li>
									<li><a class="text-gray-700" href="<?php _ec( base_url("privacy_policy") )?>"><?php _e("Privacy Policy")?></a></li>
								</ul>
							</div>

							<?php if ( 
					            get_option("social_page_facebook", "") != "" ||
					            get_option("social_page_twitter", "") != "" ||
					            get_option("social_page_pinterest", "") != "" ||
					            get_option("social_page_youtube", "") != "" ||
					            get_option("social_page_tiktok", "") != "" ||
				          	  get_option("social_page_instagram", "") != ""
				          	): ?>
				          	<div class="col-md-4 mb-5">
								<div class="fw-6 fs-18 text-primary"><?php _e("Our channels")?></div>
								<ul>
									<?php if (get_option("social_page_facebook", "") != ""): ?>
			                      		<li class="d-inline fs-30 text-gray-700 me-3"><a href="<?php _ec( get_option("social_page_facebook", "") )?>" class="text-gray-700"> <i class="fab fa-facebook-f"></i> </a></li>
				                    <?php endif ?>
				                    <?php if (get_option("social_page_twitter", "") != ""): ?>
				                    	<li class="d-inline fs-30 text-gray-700 me-3"><a href="<?php _ec( get_option("social_page_twitter", "") )?>" class="text-gray-700"> <i class="fab fa-twitter"></i> </a></li>
				                    <?php endif ?>
				                    <?php if (get_option("social_page_tiktok", "") != ""): ?>
				                    	<li class="d-inline fs-30 text-gray-700 me-3"><a href="<?php _ec( get_option("social_page_tiktok", "") )?>" class="text-gray-700"> <i class="fab fa-tiktok"></i> </a></li>
				                    <?php endif ?>
				                    <?php if (get_option("social_page_pinterest", "") != ""): ?>
				                    	<li class="d-inline fs-30 text-gray-700 me-3"><a href="<?php _ec( get_option("social_page_pinterest", "") )?>" class="text-gray-700"> <i class="fab fa-pinterest-p"></i> </a></li>
				                    <?php endif ?>
				                    <?php if (get_option("social_page_youtube", "") != ""): ?>
				                    	<li class="d-inline fs-30 text-gray-700 me-3"><a href="<?php _ec( get_option("social_page_youtube", "") )?>" class="text-gray-700"> <i class="fab fa-youtube"></i> </a></li>
				                    <?php endif ?>

				                    <?php if (get_option("social_page_instagram", "") != ""): ?>
				                    	<li class="d-inline fs-30 text-gray-700 me-3"><a href="<?php _ec( get_option("social_page_instagram", "") )?>" class="text-gray-700"> <i class="fab fa-instagram"></i> </a></li>
				                    <?php endif ?>
								</ul>
							</div>
				          	<?php endif ?>
							
						</div>
					</div>
				</div>
			</div>

			<div class="footer-bottom border-top py-3 text-center text-gray-600">
				<?php _e("© Copyright 2023. All Rights Reserved")?>
			</div>
		</div>

	</div>