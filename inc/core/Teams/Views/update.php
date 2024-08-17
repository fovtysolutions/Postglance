<?php
$permissions_selected = [];
$accounts_selected = [];
$email = "";
if(!empty($item)){
	$permissions_selected = json_decode($item->permissions, 1);
	if($item->status == 0){
		$email = $item->pending;
	}else{
		$email = $item->email;
	}
}
?>

<div class="container py-5">
	
	<form class="actionForm" action="<?php _ec( get_module_url("save/".uri("segment", 4)) )?>" method="POST" data-redirect="<?php _ec( get_module_url() )?>">
		<div class="card m-b-25 m-auto">
		    <div class="card-header">
		        <div class="card-title flex-column">
		            <h3 class="fw-bolder"><i class="fad fa-edit"></i> <?php _e("Update")?></h3>
		        </div>
		    </div>
		    <div class="card-body">
		    	
		    	<div class="mb-5">
		    		<label class="form-label" for="email" ><?php _e("Email")?></label>
		    		<input type="text" name="email" id="email" class="form-control form-control-solid" placeholder="Enter email of member you want invite to send request join to your team" value="<?php _ec( $email )?>">
		    	</div>

    			<ul class="list-group mb-4">
				  	<li class="list-group-item py-3 d-flex justify-content-between fw-6" aria-current="true"><?php _e("Permissions")?></li>
				  	<li class="border-bottom">
				  		<ul class="overflow-hidden mh-500 n-scroll no-update">
				  			<?php if (!empty( $permissions )): ?>
				  		
						  		<?php foreach ($permissions as $key => $rows): ?>
						  			
						  			<?php if ( !empty($rows) ): ?>
						  				
						  				<?php foreach ($rows as $value): ?>

						  					<?php
                                            $id = $value["id"];
                                            $name = $value["name"];
                                            $icon = $value["icon"];
                                            $color = $value["color"];
                                            $module_status = $value["id"];

                                            if(isset($value["sub_menu"]) && isset($value["sub_menu"]["id"])){
                                                $id = $value["sub_menu"]["id"];
                                                $module_status = $value["sub_menu"]["id"];
                                            }

                                            if(isset($value["sub_menu"]) && isset($value["sub_menu"]["name"])){
                                                $name = $value["sub_menu"]["name"];
                                            }

                                            if(isset($value["sub_menu"]) && isset($value["sub_menu"]["icon"])){
                                                $icon = $value["sub_menu"]["icon"];
                                            }

                                            if(isset($value["sub_menu"]) && isset($value["sub_menu"]["color"])){
                                                $color = $value["sub_menu"]["color"];
                                            }
						  					?>
						  					
						  					<li class="list-group-item py-3 d-flex justify-content-between">
										  		<label for="<?php _ec( $module_status )?>"><i class="<?php _ec( $icon )?> me-1"></i>  <?php _e( $name )?></label>
										  		<div>
										  			<div class="form-check">
								                        <input class="form-check-input check-item" id="<?php _ec( $module_status )?>" name="permissions[<?php _ec( $module_status )?>]" type="checkbox" value="1" <?php _ec( isset($permissions_selected[ $module_status ])?"checked":"" )?> >
								                        <label class="form-check-label"></label>
								                    </div>
										  		</div>
										  	</li>

										  	<?php if (isset($value['data']) && is_array($value['data']) ): ?>
										  		
										  		<?php if ( isset($value['data']['items']) && is_array($value['data']['items']) ): ?>
										  			
										  			<?php foreach ($value['data']['items'] as $sub_key => $sub): ?>

										  				<?php if ( permission( $sub["id"] ) ): ?>
												  		<li class="list-group-item py-3 d-flex justify-content-between bg-light ps-5">
											  				<label for="<?php _ec( $sub["id"] )?>"><i class="<?php _ec( $sub["icon"] )?> me-1"></i>  <?php _e( $sub["name"] )?></label>
											  				<div>
													  			<div class="form-check">
											                        <input class="form-check-input check-item" id="<?php _ec( $sub["id"] )?>" name="permissions[<?php _ec( $sub["id"] )?>]" type="checkbox" value="1" <?php _ec( isset($permissions_selected[ $sub["id"] ])?"checked":"" )?> >
											                        <label class="form-check-label"></label>
											                    </div>
													  		</div>
											  			</li>
										  				<?php endif ?>
										  			<?php endforeach ?>

										  		<?php endif ?>

										  	<?php endif ?>

										  	

						  				<?php endforeach ?>

						  			<?php endif ?>

						  		<?php endforeach ?>

						  	<?php endif ?>
				  		</ul>
				  	</li>
				</ul>
		    </div>
		    <div class="card-footer d-flex justify-content-between">
		    	<a href="<?php _ec( get_module_url() )?>" class="btn btn-secondary"><?php _e("Back")?></a>
		    	<button type="submit" class="btn btn-primary"><?php _e("Submit")?></button>
		    </div>
		</div>
	</form>

</div>