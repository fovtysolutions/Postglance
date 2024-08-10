<div class="section blogs container m-b-250 position-relative z-2">
  
  <div class="d-flex justify-content-center align-items-center h-100 mw-800 mx-auto text-center m-b-80" data-aos="fade-down">
    <div>
      <h1><?php _e("Privacy Policy")?></h1>
      <h5 class="text-gray-600"><?php _e("The information below provides details about our privacy policy and we ask that you take the time to read it.")?></h5>
    </div>
  </div>

  <section class="space-ptb">
    <div class="container">
      <div class="row justify-content-center">
        <?php _ec( htmlspecialchars_decode( get_option("privacy_policy", ""), ENT_QUOTES) )?>
      </div>
    </div>
  </section>

</div>