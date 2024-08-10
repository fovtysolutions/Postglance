<?php if (!$next): ?>
<div class="n-scroll overflow-hidden bg-light-dark fm-list row p-l-12 p-r-12 pb-3 pt-4 ajax-load-scroll-9 m-l-0 m-r-0 align-content-start mh-600" data-url="<?php _e( get_module_url("ajax_search_media/1?keyword=".$keyword."&source=".$source) )?>" data-scroll="ajax-load-scroll-9" data-call-after="File_manager.lazy();">
<?php endif ?>
<?php if (!empty($medias)): ?>
	

	<?php foreach ($medias as $key => $value): ?>

		<div class="col-3">
			<a class="fm-list-item fm-list-item-search rounded mb-4 bg-white" href="javascript:void(0);" data-file="<?php _ec( $value )?>" >
				<img class="fm-list-overplay" src="<?php _ec( get_module_path( __DIR__, "Assets/img/overplay.png" ) )?>">
				<div class="fm-list-box">
					<div class="fm-chechbox form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="file_urls[]" value="<?php _ec( $value )?>">
                        <label class="form-check-label" for="<?php _ec( $value )?>"></label>
                    </div>
					<div class="fm-list-hover h-100">
						<?php if (strpos($value, ".mp4")): ?>
							<div class="fm-list-hover overflow-hidden position-relative h-100">
								<video class="fm-video miw-100">
								  	<source src="<?php _ec( $value )?>" type="video/mp4">
									<?php _e('Your browser does not support the video tag.')?>
								</video>
							</div>
						<?php else: ?>
							<div class="fm-list-media rounded-top d-flex flex-column align-items-center justify-content-center fs-40 text-primary">
								<img class="lazy" src="<?php _ec( get_module_path( __DIR__, "Assets/img/loading.gif") )?>" data-src="<?php _ec( $value )?>">
							</div>
						<?php endif ?>
					</div>
				</div>
			</a>
		</div>			
		
	<?php endforeach ?>


<?php else: ?>
	<?php if (!$next): ?>
		<div class="p-t-100 p-b-100">
		    <div class="text-center px-4 fa-4x">
		        <i class="fas fa-spinner fa-spin"></i>
		    </div>
		</div>
	<?php else: ?>
		<?php if ($page == 1): ?>
			<div class="p-t-100 p-b-100">
			    <div class="text-center px-4">
			        <img class="mh-190 mb-4" alt="" src="<?php _e( get_theme_url() ) ?>Assets/img/empty2.png">
			    </div>
			</div>
		<?php endif ?>
	<?php endif ?>
	
<?php endif ?>
<?php if (!$next): ?>
</div>

<script type="text/javascript">
	Core.call_load_scroll(9);
	Core.ajax_load_scroll(true, 9);
	Layout.scroll();
</script>
<?php endif ?>