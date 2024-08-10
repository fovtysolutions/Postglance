<?php foreach ($result as $key => $value): ?>
<div class="col-md-4 mb-4 h-100">
	<div class="item bg-white shadow b-r-20 p-30">
		<div class="mb-3">
			<div class="w-100 h-200 b-r-10 bg-cover" style="background-image: url('<?php _ec( get_file_url( $value->img ) )?>');"></div>
		</div>
		<div class="d-flex text-gray-600 fs-12 mb-2">
			<div><?php _e("Blog")?></div>
			<div class="px-2">|</div>
			<div><?php _ec( date_show( $value->created ) )?></div>
		</div>
		<h3 class="mb-3 fs-20 fw-6"><a href="<?php _ec( base_url("blogs/".slugify($value->title)."/".$value->id) )?>"><?php _e($value->title)?></a></h3>
		<div class="mb-3"><?php _e($value->desc)?></div>
		<a class="btn btn-outline-dark btn-round" href="<?php _ec( base_url("blogs/".slugify($value->title)."/".$value->id) )?>">Read more</a>
	</div>
</div>
<?php endforeach ?>