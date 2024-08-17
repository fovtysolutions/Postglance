<div class="col-md-12">
	<h2 class="mb-5">
        <span class="me-2"><i class="<?php _ec( $config['icon'] )?> me-2" style="color: <?php _ec($config['color'])?>;"></i> <?php _e("WhatsApp report")?></span>
    </h2>
	<div class="row">
	    <div class="col-md-6">
	    	<div class="card card-custom card-custom-primary mb-4">
	    		<div class="card-header">
	    			<?php
	    			$sent_by_month = $wa_total_sent_by_month;
	    			$limit_sent_by_month = (int)permission("whatsapp_message_per_month");
	    			if($limit_sent_by_month == 0){
	    				$perent_sent_month = 0;
	    			}else{
	    				$perent_sent_month = round( ($sent_by_month/$limit_sent_by_month)*100 );
	    			}
	    			if($sent_by_month > $limit_sent_by_month){
	    				$perent_sent_month = 100;
	    			}

	    			if($sent_by_month >= $limit_sent_by_month || $perent_sent_month >= 100){
	    				$perent_sent_month = 100;
	    			}

	    			if ($perent_sent_month < 60) {
	    				$perent_type = "success";
	    			} else if($perent_sent_month >= 60 && $perent_sent_month < 80){
	    				$perent_type = "warning";
	    			}else{
	    				$perent_type = "danger";
	    			}
	    			?>

	    			<div class="px-3 p-t-18 p-b-18 b-r-10 w-100">
						<div class="d-flex justify-content-between mb-2">
							<div>
								<div class="fs-16 fw-6 text-white"><?php _e("Message by month")?></div>
								<div class="fs-12 text-gray-100"><?php _e("Limit messages by month")?></div>
							</div>
						<div class="fs-25 fw-6 text-white"><?php _ec( $wa_total_sent_by_month )?>/<?php _ec( (int)permission("whatsapp_message_per_month") )?></div>
						</div>
						<div class="progress mb-2">
					  		<div class="progress-bar bg-<?php _ec($perent_type)?>" role="progressbar" style="width: <?php _ec($perent_sent_month)?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
						<div class="d-flex justify-content-between text-gray-100 fs-12">
							<div><?php _e("Percent")?></div>
							<div class="text-gray-100 fw-6"><?php _ec( $perent_sent_month )?><?php _e("%")?></div>
						</div>
					</div>
	    		</div>
	    	</div>
	    </div>
	    <div class="col-md-6">
			<div class="card border b-r-10 mb-4">
				<div class="card-body">
					<div class="fw-9 fs-40 text-primary position-absolute t-10 r-10 opacity-20"><i class="fad fa-user-plus"></i></div>
					<div class="fs-14 text-gray-600"><?php _e("Total message sent")?></div>
					<div class="fw-9 fs-30 text-primary d-flex"><span class="me-1"><?php _ec( short_number( $wa_total_sent ) )?></span> <span class="fs-14 fw-4 d-flex align-items-center mt-2"><?php _e("Messages")?></span></div>
				</div>
			</div>
	    </div>

	    <div class="col-md-12">
			<div class="card border b-r-10 mb-4">
				<div class="card-header">
					<div class="card-title">
						<?php _e("Bulk messaging")?>
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-4 mb-4">
							<div class="card border b-r-10">
								<div class="card-body">
									<div class="fw-9 fs-40 text-primary position-absolute t-10 r-10 opacity-20"><i class="fad fa-calendar-check"></i></div>
									<div class="fs-14 text-gray-600"><?php _e("Total")?></div>
									<div class="fw-9 fs-30 text-primary d-flex"><span class="me-1"><?php _ec( short_number( $wa_bulk_total_count ) )?></span> <span class="fs-14 fw-4 d-flex align-items-center mt-2"><?php _e("Messages")?></span></div>
								</div>
							</div>
						</div>
						<div class="col-md-4 mb-4">
							<div class="card border b-r-10">
								<div class="card-body">
									<div class="fw-9 fs-40 text-success position-absolute t-10 r-10 opacity-20"><i class="fad fa-paper-plane"></i></div>
									<div class="fs-14 text-gray-600"><?php _e("Sent")?></div>
									<div class="fw-9 fs-30 text-success d-flex"><span class="me-1"><?php _ec( short_number( $wa_bulk_sent_count ) )?></span> <span class="fs-14 fw-4 d-flex align-items-center mt-2"><?php _e("Messages")?></span></div>
								</div>
							</div>
						</div>
						<div class="col-md-4 mb-4">
							<div class="card border b-r-10">
								<div class="card-body">
									<div class="fw-9 fs-40 text-danger position-absolute t-10 r-10 opacity-20"><i class="fad fa-exclamation-triangle"></i></div>
									<div class="fs-14 text-gray-600"><?php _e("Failed")?></div>
									<div class="fw-9 fs-30 text-danger d-flex"><span class="me-1"><?php _ec( short_number( $wa_bulk_failed_count ) )?></span> <span class="fs-14 fw-4 d-flex align-items-center mt-2"><?php _e("Messages")?></span></div>
								</div>
							</div>
						</div>

						<?php if(!empty($bulks)){?>
						<div class="col-md-12">
							<table class="table align-middle table-striped table-bordered">
							  	<thead>
							   		<tr>
							      		<th class="p-15  b-r-10"><?php _e("Campaign name")?></th>
							      		<th class="p-15 w-150 text-success"><?php _e("Sent")?></th>
							      		<th class="p-15 w-150 text-danger"><?php _e("Failed")?></th>
							    	</tr>
							  	</thead>
							  	<tbody>
							  		<?php foreach ($bulks as $key => $value): ?>
							    	<tr>
							      		<td class="p-15"><?php _e( $value->name )?></td>
							      		<td class="p-15"><?php _e( (int)$value->sent )?></td>
							      		<td class="p-15"><?php _e( (int)$value->failed )?></td>
							    	</tr>
							    	<?php endforeach ?>
							  	</tbody>
							</table>
						</div>	
						<?php }?>
					</div>
				</div>
			</div>
	    </div>

	    <div class="col-md-12">
			<div class="card border b-r-10 mb-4">
				<div class="card-header">
					<div class="card-title">
						<?php _e("Autoresponder")?>
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-12 mb-4">
							<div class="card border b-r-10">
								<div class="card-body">
									<div class="fw-9 fs-40 text-success position-absolute t-10 r-10 opacity-20"><i class="fad fa-paper-plane"></i></div>
									<div class="fs-14 text-gray-600"><?php _e("Sent")?></div>
									<div class="fw-9 fs-30 text-success d-flex"><span class="me-1"><?php _ec( short_number( $wa_autoresponder_count ) )?></span> <span class="fs-14 fw-4 d-flex align-items-center mt-2"><?php _e("Messages")?></span></div>
								</div>
							</div>
						</div>

						<?php if(!empty($autoresponders)){?>
						<div class="col-md-12">
							<table class="table align-middle table-striped table-bordered">
							  	<thead>
							   		<tr>
							      		<th class="p-15  b-r-10"><?php _e("Account")?></th>
							      		<th class="p-15 w-150 text-success"><?php _e("Sent")?></th>
							      		<th class="p-15 w-150 text-danger"><?php _e("Failed")?></th>
							    	</tr>
							  	</thead>
							  	<tbody>
							  		<?php foreach ($autoresponders as $key => $value): ?>
							    	<tr>
							      		<td><?php _e( $value->account_name . " (".$value->account_username.")" )?></td>
							      		<td class="p-15"><?php _e( (int)$value->sent )?></td>
							      		<td class="p-15"><?php _e( (int)$value->failed )?></td>
							    	</tr>
							    	<?php endforeach ?>
							  	</tbody>
							</table>
						</div>	
						<?php }?>
					</div>
				</div>
			</div>
	    </div>

	    <div class="col-md-12">
			<div class="card border b-r-10 mb-4">
				<div class="card-header">
					<div class="card-title">
						<?php _e("Chatbot")?>
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-12 mb-4">
							<div class="card border b-r-10">
								<div class="card-body">
									<div class="fw-9 fs-40 text-success position-absolute t-10 r-10 opacity-20"><i class="fad fa-paper-plane"></i></div>
									<div class="fs-14 text-gray-600"><?php _e("Sent")?></div>
									<div class="fw-9 fs-30 text-success d-flex"><span class="me-1"><?php _ec( short_number( $wa_chatbot_count ) )?></span> <span class="fs-14 fw-4 d-flex align-items-center mt-2"><?php _e("Messages")?></span></div>
								</div>
							</div>
						</div>

						<?php if(!empty($chatbots)){?>
						<div class="col-md-12">
							<table class="table align-middle table-striped table-bordered">
							  	<thead>
							   		<tr>
							      		<th class="p-15  b-r-10"><?php _e("Account")?></th>
							      		<th class="p-15 w-150 text-success"><?php _e("Sent")?></th>
							      		<th class="p-15 w-150 text-danger"><?php _e("Failed")?></th>
							    	</tr>
							  	</thead>
							  	<tbody>
							  		<?php foreach ($chatbots as $key => $value): ?>
							    	<tr>
							      		<td><?php _e( $value->account_name . " (".$value->account_username.")" )?></td>
							      		<td class="p-15"><?php _e( (int)$value->sent )?></td>
							      		<td class="p-15"><?php _e( (int)$value->failed )?></td>
							    	</tr>
							    	<?php endforeach ?>
							  	</tbody>
							</table>
						</div>	
						<?php }?>
					</div>
				</div>
			</div>
	    </div>
	</div>
</div>
