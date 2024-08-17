<!DOCTYPE html>
<html lang="en" dir="<?php _ec( request_service("language")->dir )?>">
    <head><base href="">
        <meta charset="utf-8" />
        <title><?php _ec( $title )?></title>
        <meta name="description" content="<?php _e( get_option("website_description", "") )?>" />
        <meta name="keywords" content="<?php _e( get_option("website_description", "") )?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="shortcut icon" href="<?php _ec( get_option("website_favicon", base_url("assets/img/favicon.svg")) )?>" />
        <link href="<?php _ec( get_theme_url() ) ?>Assets/fonts/fontawesome/css/all.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php _ec( get_theme_url() ) ?>Assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php _ec( get_theme_url() ) ?>Assets/plugins/izitoast/izitoast.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php _ec( get_theme_url() ) ?>Assets/plugins/select2/css/select2.css" rel="stylesheet" type="text/css" />
        <link href="<?php _ec( get_theme_url() ) ?>Assets/css/animate.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php _ec( get_theme_url() ) ?>Assets/css/style.css" rel="stylesheet" type="text/css" />
        <link href="<?php _ec( get_module_path(__DIR__, "/Assets/css/style.css") ) ?>" rel="stylesheet" type="text/css" />
        <script src="<?php _ec( get_theme_url() ) ?>Assets/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript">
            var PATH  = '<?php _ec( base_url()."/" )?>';
            var csrf = "<?php _ec( csrf_hash() ) ?>"; 
        </script>
    </head>
    <body>

        <div class="loading">
            <div class="loading-icon">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>

        <div class="d-flex h-100">
            <div class=" overflow-hidden position-relative d-lg-block d-none h-100 w-600 ">
                <div class="payment-banner bg-primary p-50 d-flex justify-content-between align-items-center h-100">
                    <div class="m-b-200">
                        <img src="<?php _ec( get_module_path(__DIR__, "Assets/img/payment.png") )?>" class="w-100 mb-5">
                        <h1 class="text-white mb-4"><?php _e("Simplify Your Social Media Management")?></h1>
                        <div class="text-gray-200 fs-16">
                            <i class="fad fa-quote-left me-2"></i>
                            <?php _e("Managing your social media accounts has never been easier. Our powerful tool allows you to create, schedule, and post content across all your social networks with just a few clicks. Say goodbye to the hassle of managing multiple social media accounts and hello. Start simplifying your social media management today!")?>
                            <i class="fad fa-quote-right ms-1"></i>
                        </div>
                    </div>
                </div>
            </div>
            <?php _ec( $content )?>
        </div>

        <div class="sidebar-popover"></div>

        <?php if ( get_option("embed_code_status", 1) ): ?>
            <?php _ec( htmlspecialchars_decode( get_option("embed_code", ""), ENT_QUOTES) )?>
        <?php endif ?>

        <script src="<?php _ec( get_theme_url() ) ?>Assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?php _ec( get_theme_url() ) ?>Assets/plugins/izitoast/izitoast.min.js"></script>
        <script src="<?php _ec( get_theme_url() ) ?>Assets/plugins/select2/js/select2.full.min.js"></script>
        <script src="<?php _ec( get_module_path(__DIR__, "/Assets/js/payment.js") ) ?>"></script>
        <script src="<?php _ec( get_theme_url() ) ?>Assets/js/core.js"></script>
    </body>
</html>