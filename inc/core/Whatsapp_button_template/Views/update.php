<?php
$data = false;
$sections = false;
$desc = "";
$image = "";
if( !empty($result) ){
    $data = json_decode($result->data);

    if( !empty($data) && isset($data->sections) && count($data->sections) != 0 ){
        $sections = $data->sections;
    }

    if(get_data($data, "caption")){
    	$desc = get_data($data, "caption");
    }else{
    	$desc = get_data($data, "text");
    }

    if( isset($data->image) && isset($data->image->url) ){
    	$image = remove_file_path($data->image->url);
    }

}
?>

<form class="actionForm" action="<?php _eC( get_module_url("save/".get_data($result, "ids")) )?>" method="POST" data-redirect="<?php _ec( get_module_url() ) ?>">
	<div class="container py-5">
		<div class="card b-r-6 mb-4">
			<div class="card-header">
				<div class="card-title"><i class="<?php _ec( $config['icon'] )?> me-2" style="color: <?php _ec( $config['color'] )?>;"></i> <?php _e("Button template")?></div>
			</div>

			<div class="card-body">
				<div class="mb-4">
					<label class="form-label"><?php _e("Name")?></label>
					<input type="text" name="name" class="form-control form-control-solid" placeholder="<?php _e("Enter template name")?>" value="<?php _ec( get_data($result, "name") )?>">
				</div>
				<?php if ( permission("whatsapp_send_media") ): ?>
				<label class="form-label"><?php _e("Main image")?></label>
				<?php echo view_cell('\Core\File_manager\Controllers\File_manager::mini', ["type" => "image", "select_multi" => 0]) ?>

				<script type="text/javascript">
					$(function(){
						File_manager.loadSelectedFiles(["<?php _ec( remove_file_path(  $image ) )?>"]);
					});
				</script>

				<?php endif ?>

				<label class="form-label"><?php _e("Main description")?></label>
				<?php echo view_cell('\Core\Caption\Controllers\Caption::block', ['name' => 'desc', 'placeholder' => 'Enter main description', 'value' => $desc]) ?>

				<div class="mb-4">
					<label class="form-label"><?php _e("Footer")?></label>
					<input type="text" name="footer" class="form-control form-control-solid" placeholder="<?php _e("Enter footer content")?>" value="<?php _ec( get_data($data, "footer") )?>">
				</div>
			</div>
		</div>

		<div class="card b-r-6">
			<div class="card-header">
				<div class="card-title"><?php _e("List button")?></div>
			</div>

			<div class="card-body wa-template-option">
				<?php
                $options = [];

                if( !empty($result) ){
                    $data = json_decode($result->data);
                    if( !empty($data) && isset($data->templateButtons) && count($data->templateButtons) != 0 ){
                        $options = $data->templateButtons;
                    }
                }
                ?>

                <?php if(!empty($options)){?>

                    <?php foreach ($options as $key => $value): 
                        $displayText = "";
                        if( isset( $value->quickReplyButton ) ){
                            $displayText = $value->quickReplyButton->displayText;
                        }else if( isset( $value->urlButton ) ){
                            $displayText = $value->urlButton->displayText;
                        }else if( isset( $value->callButton ) ){
                            $displayText = $value->callButton->displayText;
                        }
                    ?>

                    <div class="card border b-r-6 mb-4 wa-template-option-item">
						<div class="card-header">
							<div class="card-title"><?php _e("Button")?> <?php _ec( $key + 1 )?></div>
							<div class="card-toolbar">
								<button type="button" class="btn btn-sm btn-light-danger wa-template-option-remove px-3 b-r-6"><i class="fad fa-trash-alt pe-0 me-0"></i></button>
							</div>
						</div>
						<div class="card-body">
							<ul class="nav nav-pills mb-3 bg-light-dark rounded border" id="pills-tab">
						        <li class="nav-item">
						            <label for="btn_type_text_<?php _ec( $key + 1 )?>" class="nav-link bg-active-white text-gray-700 px-4 py-3 text-active-successy <?php _ec( get_data($value, "quickReplyButton") != false?"active":"" ) ?>" data-bs-toggle="pill" data-bs-target="#nav_btn_type_text_<?php _ec( $key + 1 )?>" type="button" role="tab"><?php _e("Text Button")?></label>
						            <input class="d-none" type="radio" name="btn_msg_type[<?php _ec( $key + 1 )?>]" id="btn_type_text_<?php _ec( $key + 1 )?>" <?php _ec( get_data($value, "quickReplyButton") != false?'checked="true"':"" ) ?> value="1">
						        </li>
						        <li class="nav-item">
						            <label for="btn_type_link_<?php _ec( $key + 1 )?>" class="nav-link bg-active-white text-gray-700 px-4 py-3 text-active-success  <?php _ec( get_data($value, "urlButton") != false?"active":"" ) ?>" data-bs-toggle="pill" data-bs-target="#nav_btn_type_link_<?php _ec( $key + 1 )?>" type="button" role="tab"><?php _e("Link Button")?></label>
				                    <input class="d-none" type="radio" name="btn_msg_type[<?php _ec( $key + 1 )?>]" id="btn_type_link_<?php _ec( $key + 1 )?>" <?php _ec( get_data($value, "urlButton") != false?'checked="true"':"" ) ?> value="2">
						        </li>
						        <li class="nav-item">
						            <label for="btn_type_call_<?php _ec( $key + 1 )?>" class="nav-link bg-active-white text-gray-700 px-4 py-3 text-active-success <?php _ec( get_data($value, "callButton") != false?"active":"" ) ?>" data-bs-toggle="pill" data-bs-target="#nav_btn_type_call_<?php _ec( $key + 1 )?>" type="button" role="tab"><?php _e("Call Action Button")?></label>
				                    <input class="d-none" type="radio" name="btn_msg_type[<?php _ec( $key + 1 )?>]" id="btn_type_call_<?php _ec( $key + 1 )?>" <?php _ec( get_data($value, "callButton") != false?'checked="true"':"" ) ?> value="3">
						        </li>
						    </ul>

					        <div class="tab-content pt-3" id="nav-tabContent">
					            <div class="mb-3">
				                    <label class="form-label"><?php _e("Display text")?></label> 
				                    <textarea name="btn_msg_display_text[<?php _ec( $key + 1 )?>]" class="form-control form-control-solid btn_msg_display_text_<?php _ec( $key + 1 )?>" placeholder="Enter your caption"><?php _ec( $displayText ) ?></textarea>
					            </div>
					            <div class="tab-pane fade <?php _ec( get_data($value, "quickReplyButton") != false?"show active":"" ) ?>" id="nav_btn_type_text_<?php _ec( $key + 1 )?>" role="tabpanel"></div>
					            <div class="tab-pane fade mb-3 <?php _ec( get_data($value, "urlButton") != false?"show active":"" ) ?>" id="nav_btn_type_link_<?php _ec( $key + 1 )?>" role="tabpanel">
				                    <label class="form-label"><?php _e("Link")?></label> 
				                    <input class="form-control form-control-solid" name="btn_msg_link[<?php _ec( $key + 1 )?>]" placeholder="<?php _e("Enter your url")?>" value="<?php _ec( get_data($value, "urlButton") != false?get_data($value->urlButton, "url"):"" ) ?>">
					            </div>
					            <div class="tab-pane fade mb-3 <?php _ec( get_data($value, "callButton") != false?"show active":"" ) ?>" id="nav_btn_type_call_<?php _ec( $key + 1 )?>" role="tabpanel">
				                    <label class="form-label"><?php _e("Phone number")?></label> 
				                    <input class="form-control form-control-solid" name="btn_msg_call[<?php _ec( $key + 1 )?>]" placeholder="<?php _e("Ex: +1 (234) 5678-901")?>" value="<?php _ec( get_data($value, "callButton") != false?get_data($value->callButton, "phoneNumber"):"" ) ?>">
					            </div>
					        </div>

					        <ul class="text-success fs-12 mb-0">
					            <li><?php _e("Random message by Spintax. Ex: {Hi|Hello|Hola}")?></li>
					            <li><?php _e("CallButton: Enter Phone number for the button")?></li>
					            <li><?php _e("UrlButton: Enter URL for the button")?></li>
					            <li><?php _e("quickReplyButton: Enter a message to quick reply for the button")?></li>
					            <li><?php _e("[Bulk messaging] - Add custom variables: %name%, %param1%, %param2%,...")?></li>
					        </ul>
						</div>
					</div>
                    <?php endforeach ?>

                <?php }else{?>
				<div class="wa-empty">
					<?php _ec( $this->include('Core\Whatsapp\Views\empty'), false);?>
				</div>
                <?php }?>

			</div>

			<div class="card-footer wa-template-wrap-add <?php _ec( count($options)>= 3?"d-none":"" )?>">
				<a href="javascript:void(0);" class="btn btn-dark px-3 btn-wa-add-option"><?php _e("Add new button")?></a>
			</div>
		</div>

		<div class="mt-5 d-flex justify-content-end">
			<button type="submit" class="btn btn-primary w-100"><?php _e("Submit")?></button>
		</div>
	</div>
</form>

<div class="wa-template-data-option d-none">
    <div class="card border b-r-6 mb-4 wa-template-option-item">
		<div class="card-header">
			<div class="card-title"><?php _e("Button")?> {count}</div>
			<div class="card-toolbar">
				<button type="button" class="btn btn-sm btn-light-danger wa-template-option-remove px-3 b-r-6"><i class="fad fa-trash-alt pe-0 me-0"></i></button>
			</div>
		</div>
		<div class="card-body">
			<ul class="nav nav-pills mb-3 bg-light-dark rounded border" id="pills-tab">
		        <li class="nav-item">
		            <label for="btn_type_text_{count}" class="nav-link bg-active-white text-gray-700 px-4 py-3 active text-active-success" data-bs-toggle="pill" data-bs-target="#nav_btn_type_text_{count}" type="button" role="tab"><?php _e("Text Button")?></label>
		            <input class="d-none" type="radio" name="btn_msg_type[{count}]" id="btn_type_text_{count}" checked="true" value="1">
		        </li>
		        <li class="nav-item">
		            <label for="btn_type_link_{count}" class="nav-link bg-active-white text-gray-700 px-4 py-3 text-active-success" data-bs-toggle="pill" data-bs-target="#nav_btn_type_link_{count}" type="button" role="tab"><?php _e("Link Button")?></label>
                    <input class="d-none" type="radio" name="btn_msg_type[{count}]" id="btn_type_link_{count}" value="2">
		        </li>
		        <li class="nav-item">
		            <label for="btn_type_call_{count}" class="nav-link bg-active-white text-gray-700 px-4 py-3 text-active-success" data-bs-toggle="pill" data-bs-target="#nav_btn_type_call_{count}" type="button" role="tab"><?php _e("Call Action Button")?></label>
                    <input class="d-none" type="radio" name="btn_msg_type[{count}]" id="btn_type_call_{count}" value="3">
		        </li>
		    </ul>

	        <div class="tab-content pt-3" id="nav-tabContent">
	            <div class="mb-3">
                    <label class="form-label"><?php _e("Display text")?></label> 
                    <textarea name="btn_msg_display_text[{count}]" class="form-control form-control-solid btn_msg_display_text_{count}" placeholder="Enter your caption"></textarea>
	            </div>
	            <div class="tab-pane fade" id="nav_btn_type_text_{count}" role="tabpanel"></div>
	            <div class="tab-pane fade mb-3" id="nav_btn_type_link_{count}" role="tabpanel">
                    <label class="form-label"><?php _e("Link")?></label> 
                    <input class="form-control form-control-solid" name="btn_msg_link[{count}]" placeholder="<?php _e("Enter your url")?>">
	            </div>
	            <div class="tab-pane fade mb-3" id="nav_btn_type_call_{count}" role="tabpanel">
                    <label class="form-label"><?php _e("Phone number")?></label> 
                    <input class="form-control form-control-solid" name="btn_msg_call[{count}]" placeholder="<?php _e("Ex: +1 (234) 5678-901")?>">
	            </div>
	        </div>

	        <ul class="text-success fs-12 mb-0">
	            <li><?php _e("Random message by Spintax. Ex: {Hi|Hello|Hola}")?></li>
	            <li><?php _e("CallButton: Enter Phone number for the button")?></li>
	            <li><?php _e("UrlButton: Enter URL for the button")?></li>
	            <li><?php _e("quickReplyButton: Enter a message to quick reply for the button")?></li>
	            <li><?php _e("[Bulk messaging] - Add custom variables: %name%, %param1%, %param2%,...")?></li>
	        </ul>
		</div>
	</div>
</div>
<script type="text/javascript">
$(function(){
	Core.tagsinput();
});
</script>