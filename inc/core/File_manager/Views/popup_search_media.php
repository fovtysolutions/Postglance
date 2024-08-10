<div class="modal fade file-manager file-manager-search-media-modal" id="file-manager" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-lg-down modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="file-manager"><i class="fad fa-search"></i> <?php _e("Search Media Online")?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-header shadow-none p-0">
                <div class="modal-title w-100">
                    <form class="actionForm" method="POST" action="<?php _e( get_module_url("ajax_search_media") )?>" data-call-after="File_manager.lazy();" data-result="html" data-content="ajax-load-search">
                        <div class="px-4 py-4">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="<?php _e("Enter keyword")?>" name="keyword">
                                <select class="form-select bg-white border mw-150" name="source">
                                    <?php if (get_option("fm_unsplash_status", 0) && get_option("fm_unsplash_access_key", "") != ""  && get_option("fm_unsplash_secret_key", "") != ""): ?>
                                    <option value="unsplash"><?php _e("Unsplash")?></option>
                                    <?php endif ?>
                                    <?php if (get_option("fm_pexels_status", 0) && get_option("fm_pexels_api_key", "") != ""): ?>
                                    <option value="pexels_photo"><?php _e("Pexels Photo")?></option>
                                    <?php endif ?>
                                    <?php if (get_option("fm_pexels_status", 0) && get_option("fm_pexels_api_key", "") != ""): ?>
                                    <option value="pexels_video"><?php _e("Pexels Video")?></option>
                                    <?php endif ?>
                                    <?php if (get_option("fm_pixabay_status", 0) && get_option("fm_pixabay_api_key", "") != ""): ?>
                                    <option value="pixabay_photo"><?php _e("Pixabay Photo")?></option>
                                    <?php endif ?>
                                    <?php if (get_option("fm_pixabay_status", 0) && get_option("fm_pixabay_api_key", "") != ""): ?>
                                    <option value="pixabay_video"><?php _e("Pixabay Video")?></option>
                                    <?php endif ?>
                                </select>
                                <button type="submit" class="input-group-text btn btn-dark fw-4"><?php _e("Search")?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <form class="actionForm" action="<?php _ec( get_module_url("save_multi_files?folder_id=".$folder_id) )?>" method="POST" data-call-after="Core.ajax_load_scroll(true);">
                <div class="modal-body shadow-none bg-light-dark p-0 ajax-load-search">
                    <div class="p-t-100 p-b-100">
                        <div class="text-center px-4">
                            <img class="mh-190 mb-4" alt="" src="<?php _e( get_theme_url() ) ?>Assets/img/empty2.png">
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal"><?php _e("Close")?></button>
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal"><?php _e("Save")?></button>
                </div>
                
            </form>
        </div>
    </div>
</div>