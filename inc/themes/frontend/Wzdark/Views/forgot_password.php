<div class="login container m-b-100 border-top">
        
    <div class="mw-1000 shadow mx-auto b-r-20 bg-gray-100">
        <form class="actionForm" action="<?php _ec( base_url("auth/forgot_password") )?>" method="POST">
            <div class="row no-gutters">
                <div class="col-md-6 justify-content-center align-items-center">
                    <div class="d-flex justify-content-center align-items-center h-100">
                        <div class="p-50 w-100">
                        <div class="headline mb-4">
                                <h2 class="fs-25 fw-6 mb-0"><?php _e("Forgot Password")?></h2>
                                <div class="text-gray-600"><?php _e("To continue first verify it's you")?></div>
                            </div>

                            <div class="mb-3">
                                <input type="text" name="email" class="form-control h-45 b-r-6 border-gray-200" value="" placeholder="<?php _e("Enter your email")?>">
                            </div>

                            <?php if(get_option('google_recaptcha_status', 0)){?>
                            <div class="g-recaptcha  mb-3" data-sitekey="<?=get_option('google_recaptcha_site_key', '')?>"></div>
                            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                            <?php }?>

                            <div class="show-message mb-2"></div>

                            <div class="mb-3">
                                <button type="submit" class="btn mb-2 btn-dark w-100 mb-md-3 fw-6 text-uppercase fs-16">
                                    Submit
                                </button>
                            </div>

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

