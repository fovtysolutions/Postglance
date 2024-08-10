<section class="page-header">
  <div class="container">
      <div class="row justify-content-center text-center">
          <div class="col-lg-7">
              <h1><?php _e("Blog")?></h1>
              <p class="lead"><?php _e("The latest articles from our content team will help you update news and reports instantly.")?></p>
          </div>
      </div>
  </div>
</section>

<section class="space-pb">
  <div class="container">
    

            <?php if (get_data($datatable, "total_items") !== 0): ?>
            <div 
                    class="ajax-pages"
                    data-aos="fade-up"
                    data-url="<?php _ec( get_module_url("ajax_blog_list") )?>" 
                    data-response=".ajax-result" 
                    data-per-page="<?php _ec( get_data($datatable, "per_page") )?>"
                    data-current-page="<?php _ec( get_data($datatable, "current_page") )?>"
                    data-total-items="<?php _ec( get_data($datatable, "total_items") )?>"
                >

                <div class="ajax-result flex-1 row" data-aos="fade-up">
                  <div class="text-center fs-90 text-gray-600 m-b-200 m-t-200">
                    <div class="lds-ripple"><div></div><div></div></div>
                  </div>
                </div>

                <div class="m-t-100 m-b-100">
                  <nav class="ajax-pagination m-auto text-center"></nav>
                </div>
            </div>
          <?php else: ?>
          <div class="container">
              <div class="d-flex align-items-center align-self-center h-100 mih-500">
                  <div class="w-100">
                      <div class="text-center px-4 fs-30 text-gray-300">
                          <?php _e("No data not found")?>
                      </div>
                  </div>
              </div>
          </div>
          <?php endif ?>


         
    </div>
  </section>

