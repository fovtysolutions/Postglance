<div class="container my-5">
    <div class="card card-flush mb-4">
        <div class="card-header mt-6">
            <div class="card-title flex-column">
                <h3 class="fw-bolder d-flex justify-content-center align-items-center"><i class="<?php _ec( $config['icon'] )?> me-2" style="color: <?php _ec( $config['color'] )?>;"></i>  <?php _e( $config['name'] )?></h3>
            </div>
        </div>
        <div class="card-body">
            <div class="alert alert-primary">
                <span class="fw-6"><?php _e("Get OpenAI access token at here:")?></span> 
                <a href="https://platform.openai.com/account/api-keys" target="_blank">https://platform.openai.com/account/api-keys</a> 
                <br/>
            </div>
            <div class="mb-4">
                <label for="openai_status" class="form-label"><?php _e('Status')?></label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="openai_status" <?php _e( get_option("openai_status", 0)==1?"checked='true'":"" )?> id="openai_status_enable" value="1">
                        <label class="form-check-label" for="openai_status_enable"><?php _e('Enable')?></label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="openai_status" <?php _e( get_option("openai_status", 0)==0?"checked='true'":"" )?> id="openai_status_disable" value="0">
                        <label class="form-check-label" for="openai_status_disable"><?php _e('Disable')?></label>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <label for="openai_api_key" class="form-label"><?php _e('Open AI API keys')?></label>
                <input type="text" class="form-control form-control-solid" id="openai_api_key" name="openai_api_key" value="<?php _ec( get_option("openai_api_key", "") )?>">
            </div>

            <div class="mb-4">
                <label for="openai_default_model" class="form-label"><?php _e('Default Openai Model')?></label>
                <select class="form-select" name="openai_default_model" id="openai_default_model">
                    <?php foreach (openai_models() as $key => $value): ?>
                        <option value="<?php _ec($key)?>" <?php _ec( get_option("openai_default_model", "gpt-3.5-turbo")==$key?"selected":"" )?>><?php _e($value)?></option>
                    <?php endforeach ?>?></option>
                </select>
            </div>

            <div class="mb-4">
                <label for="openai_default_dalle_model" class="form-label"><?php _e('Default Dall-E Model')?></label>
                <select class="form-select" name="openai_default_dalle_model" id="openai_default_dalle_model">
                    <option value="dall-e-2" <?php _ec( get_option("openai_default_dalle_model", "dall-e-3")=="dalle2"?"selected":"" )?>><?php _e("Dall-E-2")?></option>
                    <option value="dall-e-3" <?php _ec( get_option("openai_default_dalle_model", "dall-e-3")=="dalle3"?"selected":"" )?>><?php _e("Dall-E-3")?></option>
                </select>
            </div>

            <div class="mb-4">
                <label for="openai_default_language" class="form-label"><?php _e('Default Tone Of Voice')?></label>
                <select class="form-select" name="openai_default_language" id="openai_default_language">
                    <?php foreach (languages() as $key => $value): ?>
                        <option value="<?php _ec($key)?>" <?php _ec( get_option("openai_default_language", "en-US")==$key?"selected":"" )?>><?php _e($value)?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="mb-4">
                <label for="openai_default_tone_of_voice" class="form-label"><?php _e('Default Tone Of Voice')?></label>
                <select class="form-select" name="openai_default_tone_of_voice" id="openai_default_tone_of_voice">
                    <?php foreach (tone_of_voices() as $key => $value): ?>
                        <option value="<?php _ec($key)?>" <?php _ec( get_option("openai_default_tone_of_voice", "Polite")==$key?"selected":"" )?>><?php _e($value)?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="mb-4">
                <label for="openai_default_creativity" class="form-label"><?php _e('Default Creativity')?></label>
                <select class="form-select" name="openai_default_creativity" id="openai_default_creativity">
                    <?php foreach (openai_creativity() as $key => $value): ?>
                        <option value="<?php _ec($key)?>" <?php _ec( get_option("openai_default_creativity", "0.75")==$key?"selected":"" )?>><?php _e($value)?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <label for="openai_default_max_input_lenght" class="form-label"><?php _e('Maximum Input Length')?></label>
                        <input type="number" class="form-control form-control-solid" id="openai_default_max_input_lenght" name="openai_default_max_input_lenght" value="<?php _ec( get_option("openai_default_max_input_lenght", "1000") )?>">
                    </div>
                    <div class="col-md-6">
                        <label for="openai_default_max_output_lenght" class="form-label"><?php _e('Maximum Ouput Length')?></label>
                        <input type="number" class="form-control form-control-solid" id="openai_default_max_output_lenght" name="openai_default_max_output_lenght" value="<?php _ec( get_option("openai_default_max_output_lenght", "50") )?>">
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="m-t-25">
        <button type="submit" class="btn btn-primary"><?php _e('Save')?></button>
    </div>
</div>