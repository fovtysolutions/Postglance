<div class="modal fade" id="OpenAIModal" tabindex="-1" role="dialog">
  	<div class="modal-dialog modal-dialog-centered">
	    <div class="modal-content">
        	<form class="actionForm OpenAIGenerate" data-name="<?php _ec($name)?>" action="<?php _ec( get_module_url("generate") ) ?>" method="POST" data-call-success="OpenAI.saveContent(result);">
	      		<div class="modal-header">
			        <h5 class="modal-title d-flex justify-content-center align-items-center"><i class="<?php _ec( $config['icon'] )?> me-2" style="color: <?php _ec( $config['color'] )?>;"></i> <?php _ec("AI Generate Content")?></h5>
			         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		      	</div>
		      	<div class="modal-body shadow-none">
	        		<div class="mb-3">
            			<label class="form-label"><?php _e("Suggestion")?></label>
	                    <input type="text" class="form-control form-control-solid" id="suggestion" name="suggestion" value="">
	                </div>
	                <div class="row">
	                	<div class="col-md-6">
	                		<div class="mb-3">
		                    	<label class="fs-12 mb-1"><?php _e("Language")?></label>
		                    	<select class="form-select bg-white border form-select-sm" data-control="select2" name="language" required="">
		                    		<?php foreach (languages() as $key => $value): ?>
		                    			<option value="<?php _ec($key)?>" <?php _ec( (empty($data) && get_option("openai_default_language", "en-US")==$key)?"selected":"" ) ?> ><?php _e($value)?></option>
		                    		<?php endforeach ?>
		                    	</select>
		                    </div>
	                	</div>
	                	<div class="col-md-6">
	                		<div class="mb-3">
		                    	<label class="fs-12 mb-1"><?php _e("Maximum Length")?></label>
		                    	<input type="number" class="form-control form-control-sm" name="max_length" value="<?php _ec( get_option("openai_default_max_output_lenght", "200") )?>" required="">
		                    </div>
	                	</div>
	                	<div class="col-md-6">
	                		<div class="mb-3">
		                    	<label class="fs-12 mb-1"><?php _e("Tone of voice")?></label>
		                    	<select class="form-select bg-white border form-select-sm" data-control="select2" name="tone_of_voice" required="">
		                    		<?php foreach (tone_of_voices() as $key => $value): ?>
		                    			<option value="<?php _ec($key)?>" <?php _ec( get_option("openai_default_tone_of_voice", "Polite")==$key?"selected":"" ) ?>><?php _e($value)?></option>
		                    		<?php endforeach ?>
		                    	</select>
		                    </div>
	                	</div>
	                	<div class="col-md-6">
	                		<div class="mb-3">
	                			<label class="fs-12 mb-1"><?php _e("Creativity")?></label>
	                    		<select class="form-select bg-white border form-select-sm" data-control="select2" name="creativity" required="">
	                    			<?php foreach (openai_creativity() as $key => $value): ?>
		                    			<option value="<?php _ec($key)?>" <?php _ec( get_option("openai_default_creativity", "0.75")==$key?"selected":"" ) ?>><?php _e($value)?></option>
		                    		<?php endforeach ?>
								</select>
							</div>
	                	</div>
	                </div>

	                <div class="mb-3">
                        <label class="form-label"><?php _e("Add hashtags")?></label>
	                    <select class="form-select" name="hashtags">
	                    	<option value="<?php _ec(0)?>"><?php _ec(0)?></option>
            				<?php for ($i=1; $i <= 50; $i++) { ?>
            					<option value="<?php _ec($i)?>"><?php _ec($i)?></option>
            				<?php }?>
            			</select>
                    </div>
		      	</div>
		      	<div class="modal-footer d-flex justify-content-end">
		      		<button type="submit" class="btn btn-primary"><?php _e("Generate")?></button>
		      	</div>
        	</form>
	    </div>
  	</div>
</div>