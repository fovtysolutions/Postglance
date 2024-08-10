<div class="container my-5">
    <div class="card mb-4">
        <div class="card-header">
            <div class="card-title flex-column">
                <h3 class="fw-bolder"><i class="text-success <?php _e( $config['icon'] )?>"></i> <?php _e( $config['name'] )?></h3>
            </div>
        </div>
        <div class="card-body">
            <div class="mb-4">
                <label for="fm_storage_server_direct" class="form-label"><?php _e('Stogare server')?></label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="fm_storage_server" <?php _e( get_option("fm_storage_server", "direct")=="direct"?"checked='true'":"" )?> id="fm_storage_server_direct" value="direct">
                        <label class="form-check-label" for="fm_storage_server_direct"><?php _e('Direct')?></label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="fm_storage_server" <?php _e( get_option("fm_storage_server", "direct")=="aws"?"checked='true'":"" )?> id="fm_storage_server_aws" value="aws">
                        <label class="form-check-label" for="fm_storage_server_aws"><?php _e('Amazon S3')?></label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="fm_storage_server" <?php _e( get_option("fm_storage_server", "direct")=="contabo"?"checked='true'":"" )?> id="fm_storage_server_contabo" value="contabo">
                        <label class="form-check-label" for="fm_storage_server_contabo"><?php _e('Contabo S3')?></label>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <label for="fm_medias_per_page" class="form-label"><?php _e('Medias per page')?></label>
                <input type="text" class="form-control form-control-solid" id="fm_medias_per_page" name="fm_medias_per_page" value="<?php _ec( get_option("fm_medias_per_page", 36) )?>">
            </div>

            <div class="mb-4">
                <label for="fm_allow_extensions" class="form-label"><?php _e('Allow file extensions')?></label>
                <input type="text" class="form-control form-control-solid" id="fm_allow_extensions" name="fm_allow_extensions" value="<?php _ec( get_option("fm_allow_extensions", "jpeg,gif,png,jpg,mp4,csv,pdf,mp3") )?>">
            </div>

            <div class="mb-4">
                <label for="fm_allow_upload_via_url_enable" class="form-label"><?php _e('Allow upload file via url')?></label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="fm_allow_upload_via_url" <?php _e( get_option("fm_allow_upload_via_url", 1)==1?"checked='true'":"" )?> id="fm_allow_upload_via_url_enable" value="1">
                        <label class="form-check-label" for="fm_allow_upload_via_url_enable"><?php _e('Enable')?></label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="fm_allow_upload_via_url" <?php _e( get_option("fm_allow_upload_via_url", 1)==0?"checked='true'":"" )?> id="fm_allow_upload_via_url_disable" value="0">
                        <label class="form-check-label" for="fm_allow_upload_via_url_disable"><?php _e('Disable')?></label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <div class="card-title flex-column">
                <h3 class="fw-bolder"><?php _e( "Amazon S3 - Simple Storage Service" )?></h3>
            </div>
        </div>
        <div class="card-body">
            <div class="alert alert-primary">
                <div class="mb-2">
                    <span class="fw-6"><?php _e("Click this link to create Amazon S3 app:")?></span>
                    <a href="https://s3.console.aws.amazon.com/s3/home" target="_blank">https://s3.console.aws.amazon.com/s3/home</a>
                </div>
            </div>
   
            <div class="mb-3">
                <label for="fm_aws_region" class="form-label"><?php _e('Region')?></label>
                <input type="text" class="form-control form-control-solid" id="fm_aws_region" name="fm_aws_region" value="<?php _ec( get_option("fm_aws_region", "") )?>">
            </div>
            <div class="mb-3">
                <label for="fm_aws_access_key" class="form-label"><?php _e('Access Key')?></label>
                <input type="text" class="form-control form-control-solid" id="fm_aws_access_key" name="fm_aws_access_key" value="<?php _ec( get_option("fm_aws_access_key", "") )?>">
            </div>
            <div class="mb-3">
                <label for="fm_aws_secret_access_key" class="form-label"><?php _e('Secret Access Key')?></label>
                <input type="text" class="form-control form-control-solid" id="fm_aws_secret_access_key" name="fm_aws_secret_access_key" value="<?php _ec( get_option("fm_aws_secret_access_key", "") )?>">
            </div>
            <div class="mb-3">
                <label for="fm_aws_bucket_name" class="form-label"><?php _e('Bucket Name')?></label>
                <input type="text" class="form-control form-control-solid" id="fm_aws_bucket_name" name="fm_aws_bucket_name" value="<?php _ec( get_option("fm_aws_bucket_name", "") )?>">
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <div class="card-title flex-column">
                <h3 class="fw-bolder"><?php _e( "Contabo S3 - Simple Storage Service" )?></h3>
            </div>
        </div>
        <div class="card-body">
            <div class="alert alert-primary">
                <div class="mb-2">
                    <span class="fw-6"><?php _e("Click this link to create Contabo S3 app:")?></span>
                    <a href="https://contabo.com/" target="_blank">https://contabo.com/</a>
                </div>
            </div>
   
            <div class="mb-3">
                <label for="fm_contabo_region" class="form-label"><?php _e('Region')?></label>
                <input type="text" class="form-control form-control-solid" id="fm_contabo_region" name="fm_contabo_region" value="<?php _ec( get_option("fm_contabo_region", "") )?>">
            </div>
            <div class="mb-3">
                <label for="fm_contabo_access_key" class="form-label"><?php _e('Access Key')?></label>
                <input type="text" class="form-control form-control-solid" id="fm_contabo_access_key" name="fm_contabo_access_key" value="<?php _ec( get_option("fm_contabo_access_key", "") )?>">
            </div>
            <div class="mb-3">
                <label for="fm_contabo_secret_access_key" class="form-label"><?php _e('Secret Access Key')?></label>
                <input type="text" class="form-control form-control-solid" id="fm_contabo_secret_access_key" name="fm_contabo_secret_access_key" value="<?php _ec( get_option("fm_contabo_secret_access_key", "") )?>">
            </div>
            <div class="mb-3">
                <label for="fm_contabo_bucket_name" class="form-label"><?php _e('Bucket Name')?></label>
                <input type="text" class="form-control form-control-solid" id="fm_contabo_bucket_name" name="fm_contabo_bucket_name" value="<?php _ec( get_option("fm_contabo_bucket_name", "") )?>">
            </div>
            <div class="mb-3">
                <label for="fm_contabo_public_url" class="form-label"><?php _e('Public URL')?></label>
                <input type="text" class="form-control form-control-solid" id="fm_contabo_public_url" name="fm_contabo_public_url" value="<?php _ec( get_option("fm_contabo_public_url", "") )?>">
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <div class="card-title flex-column">
                <h3 class="fw-bolder"><?php _e( "Adobe Express - Image editor" )?></h3>
            </div>
        </div>
        <div class="card-body">
            <div class="alert alert-primary">
                <div class="mb-2">
                    <span class="fw-6"><?php _e("Click this link to create Adobe Express app:")?></span>
                    <a href="https://developer.adobe.com/console" target="_blank">https://developer.adobe.com/console</a>
                </div>
                <div><span class="fw-6"><?php _e("REDIRECT URI: ")?></span> <?php _ec( base_url() )?></div>
                <div><span class="fw-6"><?php _e("REDIRECT URI PATTERN: ")?></span> <?php _ec( str_replace(".", "\.", base_url()) )?></div>
            </div>
   
            <div class="mb-3">
                <label class="form-label"><?php _e('Status')?></label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="fm_adobe_status" <?php _e( get_option("fm_adobe_status", 0)==1?"checked='true'":"" )?> id="fm_adobe_status_enable" value="1">
                        <label class="form-check-label" for="fm_adobe_status_enable"><?php _e('Enable')?></label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="fm_adobe_status" <?php _e( get_option("fm_adobe_status", 0)==0?"checked='true'":"" )?> id="fm_adobe_status_disable" value="0">
                        <label class="form-check-label" for="fm_adobe_status_disable"><?php _e('Disable')?></label>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="fm_adobe_client_id" class="form-label"><?php _e('Client ID')?></label>
                <input type="text" class="form-control form-control-solid" id="fm_adobe_client_id" name="fm_adobe_client_id" value="<?php _ec( get_option("fm_adobe_client_id", "") )?>">
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <div class="card-title flex-column">
                <h3 class="fw-bolder"><?php _e( "Unsplash (Search & Get Media Online)" )?></h3>
            </div>
        </div>
        <div class="card-body">
            <div class="alert alert-primary">
                <span class="fw-6"><?php _e("Click this link to create Unsplash app:")?></span>
                <a href="https://unsplash.com/oauth/applications/new" target="_blank">https://unsplash.com/oauth/applications/new</a>
            </div>
            <div class="mb-3">
                <label class="form-label"><?php _e('Status')?></label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="fm_unsplash_status" <?php _e( get_option("fm_unsplash_status", 0)==1?"checked='true'":"" )?> id="fm_unsplash_status_enable" value="1">
                        <label class="form-check-label" for="fm_unsplash_status_enable"><?php _e('Enable')?></label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="fm_unsplash_status" <?php _e( get_option("fm_unsplash_status", 0)==0?"checked='true'":"" )?> id="fm_unsplash_status_disable" value="0">
                        <label class="form-check-label" for="fm_unsplash_status_disable"><?php _e('Disable')?></label>
                    </div>
                </div>
            </div>
            <!-- <div class="mb-3">
                <label for="fm_unsplash_app_id" class="form-label"><?php _e('Application ID')?></label>
                <input type="text" class="form-control form-control-solid" id="fm_unsplash_app_id" name="fm_unsplash_app_id" value="<?php _ec( get_option("fm_unsplash_app_id", "") )?>">
            </div> -->
            <div class="mb-3">
                <label for="fm_unsplash_access_key" class="form-label"><?php _e('Access Key')?></label>
                <input type="text" class="form-control form-control-solid" id="fm_unsplash_access_key" name="fm_unsplash_access_key" value="<?php _ec( get_option("fm_unsplash_access_key", "") )?>">
            </div>
            <div class="mb-3">
                <label for="fm_unsplash_secret_key" class="form-label"><?php _e('Secret key')?></label>
                <input type="text" class="form-control form-control-solid" id="fm_unsplash_secret_key" name="fm_unsplash_secret_key" value="<?php _ec( get_option("fm_unsplash_secret_key", "") )?>">
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <div class="card-title flex-column">
                <h3 class="fw-bolder"><?php _e( "Pexels (Search & Get Media Online)" )?></h3>
            </div>
        </div>
        <div class="card-body">
            <div class="alert alert-primary">
                <span class="fw-6"><?php _e("Click this link to create Pexels app:")?></span>
                <a href="https://www.pexels.com/api/new/" target="_blank">https://www.pexels.com/api/new/</a>
            </div>
            <div class="mb-3">
                <label class="form-label"><?php _e('Status')?></label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="fm_pexels_status" <?php _e( get_option("fm_pexels_status", 0)==1?"checked='true'":"" )?> id="fm_pexels_status_enable" value="1">
                        <label class="form-check-label" for="fm_pexels_status_enable"><?php _e('Enable')?></label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="fm_pexels_status" <?php _e( get_option("fm_pexels_status", 0)==0?"checked='true'":"" )?> id="fm_pexels_status_disable" value="0">
                        <label class="form-check-label" for="fm_pexels_status_disable"><?php _e('Disable')?></label>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="fm_pexels_api_key" class="form-label"><?php _e('API key')?></label>
                <input type="text" class="form-control form-control-solid" id="fm_pexels_api_key" name="fm_pexels_api_key" value="<?php _ec( get_option("fm_pexels_api_key", "") )?>">
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <div class="card-title flex-column">
                <h3 class="fw-bolder"><?php _e( "Pexels (Search & Get Media Online)" )?></h3>
            </div>
        </div>
        <div class="card-body">
            <div class="alert alert-primary">
                <span class="fw-6"><?php _e("Click this link to create Pixabay app:")?></span>
                <a href="https://pixabay.com/api/docs/" target="_blank">https://pixabay.com/api/docs/</a>
            </div>
            <div class="mb-3">
                <label class="form-label"><?php _e('Status')?></label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="fm_pixabay_status" <?php _e( get_option("fm_pixabay_status", 0)==1?"checked='true'":"" )?> id="fm_pixabay_status_enable" value="1">
                        <label class="form-check-label" for="fm_pixabay_status_enable"><?php _e('Enable')?></label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="fm_pixabay_status" <?php _e( get_option("fm_pixabay_status", 0)==0?"checked='true'":"" )?> id="fm_pixabay_status_disable" value="0">
                        <label class="form-check-label" for="fm_pixabay_status_disable"><?php _e('Disable')?></label>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="fm_pixabay_api_key" class="form-label"><?php _e('API key')?></label>
                <input type="text" class="form-control form-control-solid" id="fm_pixabay_api_key" name="fm_pixabay_api_key" value="<?php _ec( get_option("fm_pixabay_api_key", "") )?>">
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <div class="card-title flex-column">
                <h3 class="fw-bolder"><?php _e( "Google Drive" )?></h3>
            </div>
        </div>
        <div class="card-body">
            <div class="alert alert-primary">
                <span class="fw-6"><?php _e("Click this link to create Google app:")?></span>
                <a href="https://console.developers.google.com/projectcreate" target="_blank">https://console.developers.google.com/projectcreate</a>
            </div>
            <div class="mb-3">
                <label class="form-label"><?php _e('Status')?></label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="fm_google_drive_status" <?php _e( get_option("fm_google_drive_status", 0)==1?"checked='true'":"" )?> id="fm_google_drive_status_enable" value="1">
                        <label class="form-check-label" for="fm_google_drive_status_enable"><?php _e('Enable')?></label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="fm_google_drive_status" <?php _e( get_option("fm_google_drive_status", 0)==0?"checked='true'":"" )?> id="fm_google_drive_status_disable" value="0">
                        <label class="form-check-label" for="fm_google_drive_status_disable"><?php _e('Disable')?></label>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="fm_google_api_key" class="form-label"><?php _e('Google API Key')?></label>
                <input type="text" class="form-control form-control-solid" id="fm_google_api_key" name="fm_google_api_key" value="<?php _ec( get_option("fm_google_api_key", "") )?>">
            </div>
            <div class="mb-3">
                <label for="fm_google_client_id" class="form-label"><?php _e('Google Client ID')?></label>
                <input type="text" class="form-control form-control-solid" id="fm_google_client_id" name="fm_google_client_id" value="<?php _ec( get_option("fm_google_client_id", "") )?>">
            </div>
        </div>
    </div>
        
    <div class="card mb-4">
        <div class="card-header">
            <div class="card-title flex-column">
                <h3 class="fw-bolder"><?php _e('Dropbox')?></h3>
            </div>
        </div>
        <div class="card-body">
            <div class="alert alert-primary">
                <span class="fw-6"><?php _e("Click this link to create Dropbox app:")?></span>
                <a href="https://www.dropbox.com/developers/apps/create" target="_blank">https://www.dropbox.com/developers/apps/create</a>
            </div>
            <div class="mb-3">
                <label class="form-label"><?php _e('Status')?></label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="fm_google_dropbox_status" <?php _e( get_option("fm_google_dropbox_status", 0)==1?"checked='true'":"" )?> id="fm_google_dropbox_status_enable" value="1">
                        <label class="form-check-label" for="fm_google_dropbox_status_enable"><?php _e('Enable')?></label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="fm_google_dropbox_status" <?php _e( get_option("fm_google_dropbox_status", 0)==0?"checked='true'":"" )?> id="fm_google_dropbox_status_disable" value="0">
                        <label class="form-check-label" for="fm_google_dropbox_status_disable"><?php _e('Disable')?></label>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="fm_dropbox_api_key" class="form-label"><?php _e('Dropbox API Key')?></label>
                <input type="text" class="form-control form-control-solid" id="fm_dropbox_api_key" name="fm_dropbox_api_key" value="<?php _ec( get_option("fm_dropbox_api_key", "") )?>">
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <div class="card-title flex-column">
                <h3 class="fw-bolder"><?php _e('OneDrive')?></h3>
            </div>
        </div>
        <div class="card-body">
            <div class="alert alert-primary">
                <span class="fw-6"><?php _e("Click this link to create OneDrive app:")?></span>
                <a href="https://portal.azure.com/#blade/Microsoft_AAD_RegisteredApps/ApplicationsListBlade" target="_blank">https://portal.azure.com/#blade/Microsoft_AAD_RegisteredApps/ApplicationsListBlade</a>
            </div>
            <div class="mb-3">
                <label class="form-label"><?php _e('Status')?></label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="fm_google_onedrive_status" <?php _e( get_option("fm_google_onedrive_status", 0)==1?"checked='true'":"" )?> id="fm_google_onedrive_status_enable" value="1">
                        <label class="form-check-label" for="fm_google_onedrive_status_enable"><?php _e('Enable')?></label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="fm_google_onedrive_status" <?php _e( get_option("fm_google_onedrive_status", 0)==0?"checked='true'":"" )?> id="fm_google_onedrive_status_disable" value="0">
                        <label class="form-check-label" for="fm_google_onedrive_status_disable"><?php _e('Disable')?></label>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="fm_onedrive_api_key" class="form-label"><?php _e('OneDrive API Key')?></label>
                <input type="text" class="form-control form-control-solid" id="fm_onedrive_api_key" name="fm_onedrive_api_key" value="<?php _ec( get_option("fm_onedrive_api_key", "") )?>">
            </div>
        </div>
    </div>

    <div class="m-t-25">
        <button type="submit" class="btn btn-primary"><?php _e('Save')?></button>
    </div>
</div>