<?php if ( !empty($result) ){ ?>
	
	<?php foreach ($result as $key => $value): ?>
		
		<div class="col-md-6 col-sm-12 col-xs-6 mb-4 item" data-id="<?php _e($value->ids)?>">
		    <div class="card d-flex flex-column flex-row-auto card-custom card-custom-primary rounded">
		        <div class="card-header d-block position-relative mh-220">
		        	<i class="fad fa-comments-alt fs-90 position-absolute text-white opacity-25 t-15 r-35"></i>
		        	<div class="my-3 mt-5">
		        		<div class="d-flex align-items-center">
		        			<div class="text-over">
		        				<h3 class="text-white text-over"> <?php _e($value->name)?></h3>
		        				<div class="text-white text-over"><?php _e( sprintf( __("%s contacts"), number_format($value->total_phone_number) ) )?></div>
		        			</div>
		        		</div>
		        	</div>
		        	<div class="d-flex position-relative t-30">
		        		<div class="card-stats p-20 me-2 bg-white rounded">
		        			<div class="text-success fs-20 mb-3">
		        				<i class="fad fa-paper-plane"></i>
		        			</div>
		        			<div class="fs-25 fw-6 text-gray-700"><?php _ec( number_format($value->sent) )?></div>
		        			<div class="text-gray-500"><?php _e("Sent")?></div>
		        		</div>
		        		<div class="card-stats p-20 ms-2 bg-white rounded">
		        			<div class="text-primary fs-20 mb-3">
		        				<i class="fad fa-circle-notch fa-spin"></i>
		        			</div>
		        			<div class="fs-25 fw-6 text-gray-700"><?php _ec( number_format( ($value->total_phone_number - $value->sent - $value->failed >= 0 && $value->status != 2)?$value->total_phone_number - $value->sent - $value->failed:0 ) )?></div>
		        			<div class="text-gray-500"><?php _e("Pending")?></div>
		        		</div>

		        		<div class="card-stats p-20 ms-2 bg-white rounded">
		        			<div class="text-danger fs-20 mb-3">
		        				<i class="fad fa-exclamation-triangle"></i>
		        			</div>
		        			<div class="fs-25 fw-6 text-gray-700"><?php _ec( number_format($value->failed) )?></div>
		        			<div class="text-gray-500"><?php _e("Failed")?></div>
		        		</div>
		        	</div>
		        </div>
		        <div class="card-body p-t-90 mb-2">
		        	<div class="card-status p-20 h-72 d-flex align-items-center mb-2">
		        		<?php if ($value->status != 2): ?>
		        		<form class="actionForm w-100" method="POST" action="<?php _ec( get_module_url("status/".$value->ids) )?>">
			        		<div class="form-check form-switch form-check-custom form-check-solid form-check-primary d-flex d-flex justify-content-between">
				        		<label class="form-check-label text-gray-600" for="chatbot_<?php _ec( $value->id )?>">
							        <?php _e("Status")?>
							    </label>
							    <input class="form-check-input auto-submit" name="status" type="checkbox" value="<?php _ec( $value->status )?>" id="chatbot_<?php _ec( $value->ids )?>" <?php _ec( $value->status>0?"checked":"" ) ?> >
							</div>
		        		</form>
		        		<?php else: ?>
		        		<div class="w-100 text-center">
	        				<div class="text-center w-100 h-43 overflow-auto d-flex align-items-center fw-6 text-success flex-grow-1">
	        					<div class="text-center w-100"><?php _e("The campaign has been completed.")?></div>
	        				</div>
		        		</div>
		        		<?php endif ?>
		        	</div>
		        	<p class="text-gray-600 fs-12 mb-0 text-end"><?php _e( sprintf( __("Next action: %s"), datetime_show( $value->time_post ) ) )?></p>
		        </div>
		        <div class="card-footer d-flex justify-content-end">
		        	<a href="<?php _e( get_module_url("index/update/".$value->ids) )?>" class="btn btn-light-dark text-center me-2 wp-50"><i class="fal fa-edit"></i> <?php _e("Edit")?></a>
		        	<a href="<?php _e( get_module_url("report/".$value->ids) )?>" class="btn btn-light-dark text-center me-2 wp-50"><i class="fal fa-chart-bar"></i> <?php _e("Report")?></a>
                    <a href="<?php _e( get_module_url("delete/".$value->ids) )?>" class="btn btn-light-dark text-center me-2 wp-50 actionItem" data-call-after="Core.ajax_pages();"><i class="fal fa-trash"></i> <?php _e("Delete")?></a>
		        </div>
		    </div>            
		</div>
	<?php endforeach ?>

<?php }else{ ?>
	<div class="mw-400 container d-flex align-items-center align-self-center h-100 py-5">
	    <div>
	        <div class="text-center px-4">
	            <img class="mw-100 mh-300px" alt="" src="<?php _e( get_theme_url() ) ?>Assets/img/empty2.png">
	        </div>
	    </div>
	</div> 
<?php }?>