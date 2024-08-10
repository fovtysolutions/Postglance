<?php 
if (
	(get_option("fm_unsplash_status", 0) && get_option("fm_unsplash_access_key", "") != ""  && get_option("fm_unsplash_secret_key", "") != "") || 
	(get_option("fm_pexels_status", 0) && get_option("fm_pexels_api_key", "") != "") || 
	(get_option("fm_pixabay_status", 0) && get_option("fm_pixabay_api_key", "") != "")
): ?>
<a class="dropdown-item btnOpenSearchMedia" href="javascript:void(0)"><i class="fad fa-search"></i> <?php _e("Search Media Online")?></a>
<?php endif ?>