<?php if ( !empty($result) ){ ?>
	
	<?php foreach ($result as $key => $value): ?>
		
	<tr>

		<td class="p-12">
	        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
	            <input class="form-check-input checkbox-item" type="checkbox" name="ids[]" value="<?php _e( $value->ids )?>">
	        </div>
	    </td>
		<td class="p-12" scope="row"><?php _ec( (post("current_page") - 1)*post("per_page") + $key + 1 )?></td>
		<td class="p-12"><?php _ec( $value->phone )?></td>
		<td class="p-12">
			<?php 
			if($value->params != ""){
				$params = json_decode($value->params);
			}else{
				$params = false;
			}
			if(!empty($params)){
			?>
			<select class="form-control form-control-solid">
				<optgroup label="<?php _e("Params")?>">
					<?php foreach ($params as $key => $param): ?>
					<option><?php _ec($key)?>: <?php _ec($param)?></option>
					<?php endforeach ?>
				</optgroup>
			</select>	
			<?php }?>	

		</td>
	</tr>

	<?php endforeach ?>

<?php }else{ ?>
	<td class="p-12" colspan="4">
		<div class="mw-200 container d-flex align-items-center align-self-center h-100 py-5">
		    <div>
		        <div class="text-center px-4">
		            <img class="mw-100 mh-300px" alt="" src="<?php _e( get_theme_url() ) ?>Assets/img/empty2.png">
		        </div>
		    </div>
		</div>
	</td> 
<?php }?>
