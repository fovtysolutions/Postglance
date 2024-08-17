<div class="modal fade" id="ImportContactModal" tabindex="-1" role="dialog">
  	<div class="modal-dialog modal-dialog-centered">
	    <div class="modal-content">
      		<div class="modal-header">
		        <h5 class="modal-title"><i class="<?php _ec( $config['icon'] )?>" style="color: <?php _ec( $config['color'] )?>;"></i> <?php _ec("Import contact")?></h5>
		         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      	</div>
	      	<div class="modal-body">
	        	<form class="actionForm" action="<?php _eC( get_module_url("add_contact/".get_data($result, "ids")) )?>" method="POST" data-redirect="">

			        <ul class="nav nav-pills mb-4 bg-white rounded fs-14 nx-scroll overflow-x-auto d-flex text-over b-r-6 border" id="pills-tab">
			            <li class="nav-item me-0 wp-50 text-center text-uppercase">
			                 <label for="type_import_csv" class="nav-link bg-active-primary text-gray-700 px-4 py-3 b-r-6 active text-active-white" data-bs-toggle="pill" data-bs-target="#import_csv" type="button" role="tab"><?php _e("Upload CSV")?></label>
			                 <input class="d-none" type="radio" name="type" id="type_import_csv" checked="true" value="1">
			            </li>
			            <li class="nav-item me-0 wp-50 text-center text-uppercase">
			                 <label for="type_import_form" class="nav-link bg-active-primary text-gray-700 px-4 py-3 b-r-6 text-active-white" data-bs-toggle="pill" data-bs-target="#import_form" type="button" role="tab"><?php _e("Via Form")?></label>
			                 <input class="d-none" type="radio" name="type" id="type_import_form" value="2">
			            </li>
			        </ul>

			        <div class="tab-content" id="pills-tabContent">
			            <div class="tab-pane fade show active p-50" id="import_csv">
	                        <div class="mb-3">
	                            <a href="<?php _e( get_module_url("download_example_upload_csv") )?>" class="btn btn-secondary btn-block w-100">
	                                <i class="fas fa-download"></i> <?php _e("Example template")?>
	                            </a>
	                        </div>
	                        <button type="button" class="btn btn-success btn-block fileinput-button w-100">
	                            <i class="fas fa-upload"></i> <?php _e("Upload CSV")?>
	                            <input id="import_whatsapp_contact" type="file" name="files[]" multiple="" data-action="<?php _ec( get_module_url("do_import_contact/".get_data($result, "ids")) )?>">
	                        </button>
			            </div>
			            <div class="tab-pane fade" id="import_form">
			                   
	                        <label for="phone_numbers" class="form-label">
	                            <?php _e('Add multiple phone numbers')?>
	                        </label>
	                        <textarea class="form-control form-control-solid" name="phone_numbers" id="phone_numbers" rows="20" placeholder="<?php _e("Validate exapmle:")?>

841234567890
840123456789
+840123456798
84123456789-1618177713@g.us"></textarea>
	                        <div class="d-flex justify-content-between mt-5">
	                            <a href="<?php _ec( get_module_url() )?>" class="btn btn-dark btn-hover-scale">
	                                <?php _e("Back")?>
	                            </a>
	                            <button type="submit" class="btn btn-primary btn-hover-scale">
	                                <i class="fal fa-paper-plane"></i> <?php _e("Submit")?>
	                            </button>
	                        </div>
			            </div>
			        </div>

				        
				     
				</form>
	      	</div>
	    </div>
  	</div>
</div>

<script type="text/javascript">
	$(function(){
		Whatsapp.import_contact();
	});
</script>