<div class="section blogs container m-b-250 position-relative z-2">
  
  <div class="d-flex justify-content-center align-items-center h-100 mw-800 mx-auto text-center m-b-80" data-aos="fade-down">
    <div>
      <h1><?php _ec($result->title)?></h1>
      <h5 class="text-gray-600"><?php _ec($result->desc)?></h5>
    </div>
  </div>

  <div class="row">
    <div class="col-md-8">
      <img class="w-100 b-r-20 m-b-50" src="<?php _ec( get_file_url($result->img) )?>" class="img-fluid card-img-top" alt="<?php _ec($result->title)?>">
      <div class="card-body">
        <?php _ec($result->content)?>
      </div>
      <div class="d-flex justify-content-end text-gray-600 fs-14 mb-2">
        <div><?php _e("Blog")?></div>
        <div class="px-2">|</div>
        <div><?php _ec( date_show( $result->created ) )?></div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="m-b-30" data-aos="fade-down">
            <div>
              <h1 class="fs-22 fw-6"><?php _e("Recent Post")?></h1>
            </div>
          </div>
        <div class="b-r-20 shadow bg-gray-100 py-3 px-4" data-aos="fade-up">
          <?php foreach ($recent_posts as $key => $value): ?>
            <div class="d-flex">
              <div class="item d-flex my-3">
                <div class="me-3">
                  <div class="w-80 h-80 b-r-10 bg-cover" style="background-image: url('<?php _ec( get_file_url( $value->img ) )?>');"></div>
                </div>
                <div>
                  <h3 class="mb-1 fs-14 fw-6"><a href="<?php _ec( base_url("blogs/".slugify($value->title)."/".$value->id) )?>"><?php _e($value->title)?></a></h3>
                  <div class="d-flex text-gray-600 fs-10 mb-2">
                    <div><?php _e("Blog")?></div>
                    <div class="px-2">|</div>
                    <div><?php _ec( date_show( $value->created ) )?></div>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach ?>
        </div>

    </div>
  </div>

</div>