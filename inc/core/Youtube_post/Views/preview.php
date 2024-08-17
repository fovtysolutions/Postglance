<div class="pv-header mb-3 d-flex align-items-center"><i class="<?php _ec($config['icon'])?> pe-2 fs-20" style="color: <?php _ec($config['color'])?>;"></i> <?php _ec($config['name'])?></div>
<div class="pv-body border rounded" data-support-type="media">
	<div class="preview-item  preview-youtube">
		<div class="pvi-body">
			<div class="piv-video w-100">
				<img src="<?php _ec( get_theme_url()."Assets/img/video-default.jpg" )?>" class="w-100">
			</div>
			<div class="p-10 fs-14">
				<div class="piv-advance youtube_title fw-6">
					<div class="line-no-text"></div>
					<div class="line-no-text w50"></div>
				</div>
			</div>
		</div>
		<div class="pvi-footer px-3 py-2">
			<div class="d-flex w-100">
				<div class="symbol symbol-45px me-3">
					<img src="<?php _ec( get_theme_url()."Assets/img/avatar.jpg" )?>" class="rounded-circle align-self-center" alt="">
				</div>
				<div class="w-100">
					<div class="flex-grow-1 me-2 text-over-all fs-12">
						<a href="javascript:void(0);" class="text-gray-800 text-hover-primary fw-bold"><?php _e("Your name")?></a>
						<span class="text-muted fw-semibold d-block fs-10"><?php _e( sprintf( __("Published on %s"), date("M j")) )?> <i class="fas fa-globe"></i></span>
					</div>
					<div class="pvi-body mt-3">
						<div class="piv-text p-b-13 fs-12"></div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="piv-not-support d-none">
		<div class="p-20 text-danger opacity-75 fs-12 text-center"><?php _e("Youtube doesn't allow posts with text type")?></div>
	</div>
</div>