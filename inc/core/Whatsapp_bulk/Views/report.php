<table style="width: 1366px; border: 1px solid #000000; font-family: Tahoma; margin: auto;">
	<tr>
		<th colspan="6" style="height: 80px; background-color: #428200; text-transform: uppercase; font-size: 30px; color: #fff;">
			<?php _e( $result->name )?>
		</th>
	</tr>
	<tr>
	    <th style="background: #bada99; height: 30px; text-transform: uppercase; color: #000; padding: 5px; border: 1px solid #000000; text-align: left;"><?php _e("Contact group")?></th>
	    <th colspan="5" style="color: #000; padding: 5px; border: 1px solid #000000; text-align: left;"><?php _e( $result->contact_name )?></th>
  	</tr>
  	<tr>
	    <th style="background: #bada99; height: 30px; text-transform: uppercase; color: #000; padding: 5px; border: 1px solid #000000; text-align: left;"><?php _e("Min delay")?></th>
	    <th colspan="2" style="color: #000; padding: 5px; border: 1px solid #000000; text-align: left;"><?php _e( $result->min_delay )?></th>
	    <th style="background: #bada99; height: 30px; text-transform: uppercase; color: #000; padding: 5px; border: 1px solid #000000;  text-align: left;"><?php _e("Max delay")?></th>
	    <th colspan="2" style="color: #000; padding: 5px; border: 1px solid #000000; text-align: left;"><?php _e( $result->max_delay )?></th>
  	</tr>
  	<tr>
	    <th style="background: #bada99; height: 30px; text-transform: uppercase; color: #000; padding: 5px; border: 1px solid #000000; text-align: left;"><?php _e("Start time")?></th>
	    <th colspan="2" style="color: #000; padding: 5px; border: 1px solid #000000; text-align: left;"><?php _e( $result->created )?></th>
	    <th style="background: #bada99; height: 30px; text-transform: uppercase; color: #000; padding: 5px; border: 1px solid #000000; text-align: left;"><?php _e("End time")?></th>
	    <th colspan="2" style="color: #000; padding: 5px; border: 1px solid #000000; text-align: left;"><?php _e( date("Y-m-d H:i:s", $result->time_post) )?></th>
  	</tr>
  	<tr>
	    <th colspan="6" style="height: 40px;" ></th>
  	</tr>
  	<tr>
	    <th colspan="3" style="height: 25px; color: #000; padding: 5px; border: 1px solid #000000;"><?php _e("Phone number")?></th>
	    <th colspan="3" style="height: 25px; color: #000; padding: 5px; border: 1px solid #000000;"><?php _e("Status")?></th>
  	</tr>
  	<?php if ($result->result != ""): ?>
	  	<?php 
	  	$data = json_decode($result->result, false);
	  	if(!empty($data)){
	  	?>
		  	<?php foreach ($data as $key => $value): ?>
		  		<?php if (is_object($value)): ?>
			  	<tr>
				    <td colspan="3" style="height: 25px; padding: 5px; border: 1px solid #000000; text-align: left;"><?php _e( $value->phone_number )?></td>
				    <td colspan="3" style="height: 25px; padding: 5px; border: 1px solid #000000; text-align: center; color: <?php _e( $value->status?"#009f19":"#f00" )?>;"><?php _e( $value->status?_e("Successed"):_e("Failed") )?></td>
			  	</tr>
		  		<?php endif ?>
		  	<?php endforeach ?>

	  	<?php }?>
  	<?php endif ?>
</table>