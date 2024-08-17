<div class="pv-header mb-3 d-flex align-items-center"><i class="<?php _ec($config['icon'])?> pe-2 fs-20" style="color: <?php _ec($config['color'])?>;"></i> <?php _ec($config['name'])?></div>
<div class="pv-body border rounded" data-support-type="media,link">
	<div class="preview-item  preview-pinterest">
		<div class="pvi-body">
			<div class="piv-img w-100">
				<img src="<?php _ec( get_theme_url()."Assets/img/default.jpg" )?>" class="w-100">
			</div>
			<div class="piv-link w-100 d-none">
				<div class="piv-link-img w-100">
					<img src="<?php _ec( get_theme_url()."Assets/img/default.jpg" )?>" class="w-100">
				</div>
			</div>
			<div class="p-10 fs-12"><?php _e("Upload by")?> <span class="fw-6"><?php _e("Username")?></span></div>
		</div>
		<div class="pvi-footer border-top px-3 py-2">
			<div class="d-flex w-100">
				<div class="symbol symbol-25px me-3">
					<img src="<?php _ec( get_theme_url()."Assets/img/avatar.jpg" )?>" class="align-self-center rounded-circle" alt="">
				</div>
				<div class="d-flex align-items-center flex-row-fluid flex-wrap">
					<div class="flex-grow-1 me-2 mb-2 text-over-all">
						<a href="javascript:void(0);" class="text-gray-800 text-hover-primary fs-12">
							<span class="fw-6"><?php _e("Username")?></span> <?php _e("Saved")?> <span class="fw-6">Board</span>
						</a>
						<div class="pvi-body mt-3">
							<div class="piv-text p-b-13 fs-12"></div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

	<div class="piv-not-support d-none">
		<div class="p-20 text-danger opacity-75 fs-12 text-center"><?php _e("Instagram doesn't allow posts with text type")?></div>
	</div>
</div>