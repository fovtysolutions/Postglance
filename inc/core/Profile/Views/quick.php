<div class="col-md-12">
	<div class="row">
		<div class="col-md-4 mb-4">
			<div class="card">
				<div class="card-body bg-gray-800 shadow b-r-15 d-flex p-0 justify-content-between">
					
					<div class="text-gray-100 p-25 flex-fill miw-200">
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
						<a href="<?php _ec( base_url("profile/index/plan") )?>" style="background-color:#fff!important;" class="btn bg-gray-100 b-r-6 text-gray-900 mt-2 b-r-15 fw-5"><?php _e("View plan")?></a>
					</div>
					
					
					<div class="flex-fill pt-4">
						<img src="<?php _ec( get_module_path( __DIR__, "Assets/img/favicon.png" ) )?>" class="imgg"> 
					
					</div>
					

				</div>
			</div>
		</div>
		<div class="col-md-8 mb-4">
			<div class="card b-r-15 b-r-15 p-24 border" style="background-color:#FEF4EA!important">
				<div class="row card-body d-flex no-update w-100 p-5" style="margin-left: 0px;">
					<?php if (!empty($result)): ?>
						
						<?php foreach ($result as $key => $value): ?>
							<?php if ($value['name']  == "Account manager" || $value['name']  == "File manager" || $value['name']  == "Schedules" ): ?>
								<div class="col-md-4 margin-bottom">
								<a href="<?php _ec( base_url( $value["id"] ) )?>" class="d-block border b-r-15 p-20 miw-200 text-over-all bg-gray-100 text-center">
									<div class="fs-50 text-primary">
										<i class="<?php _ec($value['icon'])?>" style="color: #EF3208"></i>
									</div>

									<div class="fw-6 text-gray-800">
										<?php _e($value['name'])?>
									</div>
								</a>
							</div>
							<?php endif ?>
						<?php endforeach ?>

					<?php endif ?>

				</div>
			</div>
		</div>
	</div>
</div>
