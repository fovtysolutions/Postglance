<div class="pv-header mb-3 d-flex align-items-center"><i class="<?php _ec($config['icon'])?> pe-2 fs-20" style="color: <?php _ec($config['color'])?>;"></i> <?php _ec($config['name'])?></div>
<div class="pv-body border rounded">
	<div class="preview-item preview-facebook">
		
		<div class="pvi-header d-flex p-13">
			
			<div class="d-flex flex-stack">
				<div class="symbol symbol-45px me-3">
					<img src="<?php _ec( get_theme_url()."Assets/img/avatar.jpg" )?>" class="align-self-center rounded-circle" alt="">
				</div>
				<div class="d-flex align-items-center flex-row-fluid flex-wrap">
					<div class="flex-grow-1 me-2 text-over-all">
						<a href="javascript:void(0);" class="text-gray-800 text-hover-primary fs-12 fw-bold"><?php _e("Your name")?></a>
						<span class="text-muted fw-semibold d-block fs-12"><?php _ec( date("M j") )?></span>
					</div>
				</div>
			</div>

		</div>

		<div class="pvi-body">
			
			<div class="piv-text px-3 p-b-13"></div>

			<div class="piv-img w-100">
				<img src="<?php _ec( get_theme_url()."Assets/img/default.jpg" )?>" class="w-100">
			</div>

			<div class="piv-link w-100 d-none">
				<div class="piv-link-img w-100">
					<img src="<?php _ec( get_theme_url()."Assets/img/default.jpg" )?>" class="w-100">
				</div>
			</div>
		</div>

		<div class="pvi-footer border-top px-3 py-2">
			<div class="d-flex justify-content-end">
				<div class="d-flex flex-stack">
					<div class="symbol symbol-45px me-2 text-gray-700">
						<i class="fas fa-share-alt"></i>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>