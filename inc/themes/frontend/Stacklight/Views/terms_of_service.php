<div class="section blogs container m-b-250 position-relative z-2">
  
  <div class="d-flex justify-content-center align-items-center h-100 mw-800 mx-auto text-center m-b-80" data-aos="fade-down">
    <div>
      <h1><?php _e("Terms & Conditions")?></h1>
      <h5 class="text-gray-600"><?php _e("The following information is important as it provides an overview of our terms of services, which we recommend you review.")?></h5>
    </div>
  </div>

  <section class="space-ptb">
    <div class="container">
      <div class="row justify-content-center">
        <?php _ec( htmlspecialchars_decode( get_option("terms_of_use", ""), ENT_QUOTES) )?>
      </div>
    </div>
  </section>

</div>