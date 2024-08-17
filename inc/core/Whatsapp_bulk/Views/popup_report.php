<div class="modal fade" id="ReportBulkModal" tabindex="-1" role="dialog">
  	<div class="modal-dialog modal-dialog-centered">
	    <div class="modal-content">
      		<div class="modal-header">
		        <h5 class="modal-title"><i class="<?php _ec( $config['icon'] )?>" style="color: <?php _ec( $config['color'] )?>;"></i> <?php _ec("Bulk Report")?></h5>
		         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      	</div>
	      	<div class="modal-body p-t-50 p-b-50">
	        	<form action="<?php _eC( get_module_url("report_by_day/".get_data($result, "ids")) )?>" method="POST" data-loading="false">

					<div class="text-center d-md-flex justify-content-center">
						<div class="daterange no-submit mb-3 me-3 dashed radius"></div>
						<button type="submit" class="btn btn-success btn-sm mb-3"><?php _e("Report")?></button>
					</div>
								     
				</form>
	      	</div>
	    </div>
  	</div>
</div>

<script type="text/javascript">
	$(function(){
    	Core.datarange();
    });
</script>