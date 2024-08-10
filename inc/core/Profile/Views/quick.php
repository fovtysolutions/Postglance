<div class="col-md-12">
	<div class="row">
		<div class="col-md-4 mb-4">
			<div class="card">
				<div class="card-body bg-gray-800 shadow b-r-15 d-flex p-0 justify-content-between">
					
					<div class="text-gray-100 p-25 flex-fill miw-220">
						<div class="fw-6 text-gray-100 fs-16"><span class="d-inline-block text-over mw-210">Welcome 🎉 <?php _ec( get_user("fullname") )?> </div>
						<div class="fs-12">
							<?php
						    $expiration_date = get_user("expiration_date");
						    ?>
						    <?php if ($expiration_date > time()): ?>
						        <?php _ec( sprintf( __("Expire date: %s"), date_show( get_user("expiration_date") ) ) )?>
						    <?php else: ?>
						        <?php if ($expiration_date == 0): ?>
						            <?php _e( sprintf( __("Expire date: %s"), __("Unlimited") ) )?>
						        <?php else: ?>
						            <span class="text-warning"><?php _ec("Subscription has expired")?></span>
						        <?php endif ?>
						    <?php endif ?>
						</div>
						<div class="fs-20 mt-3 fw-6">
							<?php if ($plan): ?>
								<?php _ec($plan->name)?>
							<?php else: ?>
								<?php _e("No plan")?>
							<?php endif ?>


						</div>
						<a href="<?php _ec( base_url("profile/index/plan") )?>" class="btn bg-gray-100 b-r-6 text-gray-900 mt-2 b-r-15 fw-5"><?php _e("View plan")?></a>
					</div>
					<div class="flex-fill">
						<img src="<?php _ec( get_module_path( __DIR__, "Assets/img/badge.svg" ) )?>" class="w-99">
					</div>

				</div>
			</div>
		</div>
		<div class="col-md-8 mb-4">
			<div class="card b-r-15 b-r-15 p-20 border">
				<div class="card-body d-flex nx-scroll no-update w-100 p-5">
					<?php if (!empty($result)): ?>
						
						<?php foreach ($result as $key => $value): ?>
							<a href="<?php _ec( base_url( $value["id"] ) )?>" class="d-block border b-r-15 p-20 miw-150 text-over-all bg-gray-100 me-4 text-center">
								<div class="fs-50 text-primary">
									<i class="<?php _ec($value['icon'])?>" style="color: <?php _ec($value['color'])?>"></i>
								</div>

								<div class="fw-6 text-gray-800">
									<?php _e($value['name'])?>
								</div>
							</a>
						<?php endforeach ?>

					<?php endif ?>

				</div>
			</div>
		</div>
	</div>
</div>
