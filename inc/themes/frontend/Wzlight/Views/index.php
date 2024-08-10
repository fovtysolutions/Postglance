<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="keywords" content="<?php _ec( get_option("website_keyword", "social network, marketing, brands, businesses, agencies, individuals") )?>" />
    <meta name="description" content="<?php _ec( get_option("website_description", "Let start to manage your social media so that you have more time for your business.") )?>" />
    <meta name="author" content="stackposts.com" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php _ec( get_option("website_title", "#1 Social Media Management & Analysis Platform") )?></title>
    <link rel="shortcut icon" href="<?php _ec( get_option("website_favicon", base_url("assets/img/favicon.svg")) )?>" />
	<link rel="stylesheet" type="text/css" href="<?php _ec( get_theme_url() ) ?>Assets/fonts/fontawesome/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="<?php _ec( get_theme_url() ) ?>Assets/fonts/flags/flag-icon.css" />
	<link rel="stylesheet" type="text/css" href="<?php _ec( get_frontend_url() )?>Assets/plugins/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php _ec( get_frontend_url() )?>Assets/plugins/limarquee/limarquee.css">
	<link rel="stylesheet" type="text/css" href="<?php _ec( get_frontend_url() )?>Assets/plugins/pagination/pagination.min.css">
	<link rel="stylesheet" type="text/css" href="<?php _ec( get_frontend_url() )?>Assets/css/icomoon/icomoon.css">
	<link rel="stylesheet" type="text/css" href="<?php _ec( get_frontend_url() )?>Assets/plugins/aos/aos.css">
	<link rel="stylesheet" type="text/css" href="<?php _ec( get_frontend_url() )?>Assets/css/style.css">
	<script type="text/javascript">
        var PATH  = '<?php _ec( base_url()."/" )?>';
        var csrf = "<?php _ec( csrf_hash() ) ?>";
    </script>
</head>
<body>

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
								    		<li><a class="dropdown-item py-2 actionItem" href="<?php _ec( base_url("auth/language/".$value->ids) )?>" data-redirect=""><i class="<?php _ec($value->icon)?>"></i> <?php _e($value->name)?></a></li>
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

    <?php _ec( $content )?>
	
    <?php if ( uri("segment", 1) != "login" && uri("segment", 1) != "signup" && uri("segment", 1) != "forgot_password" && uri("segment", 1) != "activation" && uri("segment", 1) != "resend_activation" && uri("segment", 1) != "recovery_password" ): ?>
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
							<div class="text-gray-600"><?php _e("Helping you execute a comprehensive Whatsapp marketing plan, and manage your brands with our features to optimize performance on the WhatsApp platform")?></div>
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
	<?php endif ?>

	<div class="scroll-top">
		<a class="icon w-55 h-55 text-primary position-relative d-flex justify-content-center align-items-center" href="#home">
			<div class="hover position-absolute w-100 h-100 border-primary b-r-60 rotating"></div>
			<i class="fal fa-chevron-up moveup text-primary fs-30"></i>
		</a>
	</div>


	<!--JS-->
	<script type="text/javascript" src="<?php _ec( get_frontend_url() )?>Assets/plugins/jquery/jquery.min.js"></script>
	<script type="text/javascript" src="<?php _ec( get_frontend_url() )?>Assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script type="text/javascript" src="<?php _ec( get_frontend_url() )?>Assets/plugins/limarquee/limarquee.js"></script>
	<script type="text/javascript" src="<?php _ec( get_frontend_url() )?>Assets/plugins/ihavecookies/jquery.ihavecookies.js"></script>
	<script type="text/javascript" src="<?php _ec( get_frontend_url() )?>Assets/plugins/pagination/pagination.min.js"></script>
	<script type="text/javascript" src="<?php _ec( get_frontend_url() )?>Assets/plugins/aos/aos.js"></script>
	<script type="text/javascript" src="<?php _ec( get_frontend_url() )?>Assets/js/core.js"></script>

	<?php if (get_option("gdpr_status", 1)): ?>
    <script type="text/javascript">
        $(function(){
            $('body').ihavecookies({
                title:"<?php _e("Cookies & Privacy")?>",
                message:"<?php _e("We use cookies to ensure that we give you the best experience on our website. By clicking Accept or continuing to use our site, you consent to our use of cookies and our privacy policy. For more information, please read our privacy policy.")?>",
                acceptBtnLabel:"<?php _e("Accept cookies")?>",
                advancedBtnLabel:"<?php _e("Customize cookies")?>",
                moreInfoLabel: "<?php _e("More information")?>",
                cookieTypesTitle: "<?php _e("Select cookies to accept")?>",
                fixedCookieTypeLabel: "<?php _e("Necessary")?>",
                fixedCookieTypeDesc: "<?php _e("These are cookies that are essential for the website to work correctly.")?>",
                link: '<?php _ec( base_url("privacy_policy") )?>',
                expires: 30,
                cookieTypes: [
                {
                    type: '<?php _e("Site Preferences")?>',
                    value: 'preferences',
                    description: '<?php _e("These are cookies that are related to your site preferences, e.g. remembering your username, site colours, etc.")?>'
                },
                {
                    type: '<?php _e("Analytics")?>',
                    value: 'analytics',
                    description: '<?php _e("Cookies related to site visits, browser types, etc.")?>'
                },
                {
                    type: '<?php _e("Marketing")?>',
                    value: 'marketing',
                    description: '<?php _e("Cookies related to marketing, e.g. newsletters, social media, etc")?>'
                }
            ],
            });
        });
    </script>
    <?php endif ?>
</body>
</html>