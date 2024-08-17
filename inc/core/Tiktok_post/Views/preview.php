<div class="pv-header mb-3 d-flex align-items-center"><i class="<?php _ec($config['icon'])?> pe-2 fs-20" style="color: <?php _ec($config['color'])?>;"></i> <?php _ec($config['name'])?></div>
<div class="pv-body border rounded" data-support-type="media">
	<div class="preview-item  preview-tiktok">
		<div class="pvi-footer px-3 py-2">
			<div class="d-flex w-100">
				<div class="symbol symbol-45px me-3">
					<img src="<?php _ec( get_theme_url()."Assets/img/avatar.jpg" )?>" class="rounded-circle align-self-center" alt="">
				</div>
				<div class="w-100">
					<div class="flex-grow-1 me-2 text-over-all fs-14">
						<a href="javascript:void(0);" class="text-gray-800 text-hover-primary fw-bold"><?php _e("Username")?> <span class="fw-4 text-gray-400 fs-12"><?php _e("Your name")?></span></a>
					</div>
					<div class="pvi-body mt-1">
						<div class="piv-text p-b-13 fs-12"></div>
					</div>

					<div class="pvi-body">
						<div class="piv-video w-100">
							<img src="<?php _ec( get_theme_url()."Assets/img/video-default.jpg" )?>" class="w-100">
						</div>

						
					</div>
				</div>

			</div>
		</div>
		
	</div>

	<div class="piv-not-support d-none">
		<div class="p-20 text-danger opacity-75 fs-12 text-center"><?php _e("Tiktok doesn't allow posts with text type")?></div>
	</div>
</div>