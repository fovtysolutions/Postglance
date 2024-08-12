<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="keywords" content="<?php _ec( get_option("website_keyword", "social network, marketing, brands, businesses, agencies, individuals") )?>" />
    <meta name="description" content="<?php _ec( get_option("website_description", "Let start to manage your social media so that you have more time for your business.") )?>" />
    <meta name="author" content="" />
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

	<?php // require_once 'header.php' ?>
    <?php _ec( $content )?>
	
    
	<?php if ( uri("segment", 1) != "login" && uri("segment", 1) != "signup" && uri("segment", 1) != "forgot_password" && uri("segment", 1) != "activation" && uri("segment", 1) != "resend_activation" && uri("segment", 1) != "recovery_password" ): ?>
	<?php // require_once 'footer.php' ?>
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