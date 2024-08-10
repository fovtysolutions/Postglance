<?php foreach ($result as $key => $value): ?>
<div class="col-md-4 mb-5 mb-md-0">
	<div class="blog bg-white shadow-sm border-0">
	  	<img class="img-fluid w-100" src="<?php _ec( get_file_url( $value->img ) )?>" alt="">
	  	<svg class="blog-shape" xmlns="http://www.w3.org/2000/svg" width="100%" height="200" viewBox="0 0 1920 100">
	    <path class="" fill="#ffffff" d="M0,80S480,0,960,0s960,80,960,80v20H0V80Z"></path></svg>
	    <div class="card-body p-30 pt-0">
	      	<a class="mb-0 font-weight-normal" href="#"><?php _e("Blog")?></a>
	      	<h4 class="font-weight-normal mt-2"><a class="text-dark" href="<?php _ec( base_url("blogs/".slugify($value->title)."/".$value->id) )?>"><?php _e($value->title)?></a></h4>
	      	<hr>
	      	<div class="d-flex">
	        	<a class="text-dark me-3 small" href="#"> <i class="far fa-clock text-primary me-1"></i><?php _ec( date_show( $value->created ) )?></a>
	      	</div>
	    </div>
 	</div>
</div>
<?php endforeach ?>