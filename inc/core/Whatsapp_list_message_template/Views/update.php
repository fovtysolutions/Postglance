<?php
$data = false;
$sections = false;
if( !empty($result) ){
    $data = json_decode($result->data);

    if( !empty($data) && isset($data->sections) && count($data->sections) != 0 ){
        $sections = $data->sections;
    }
}

?>

<form class="actionForm" action="<?php _eC( get_module_url("save/".get_data($result, "ids")) )?>" method="POST" data-redirect="<?php _e( get_module_url() )?>">
	<div class="container py-5">
		<div class="card b-r-6 mb-4">
			<div class="card-header">
				<div class="card-title"><i class="<?php _ec( $config['icon'] )?> me-2" style="color: <?php _ec( $config['color'] )?>;"></i> <?php _e("List message template")?></div>
			</div>

			<div class="card-body">
				<div class="mb-4">
					<label class="form-label"><?php _e("Name")?></label>
					<input type="text" name="name" class="form-control form-control-solid" value="<?php _ec( get_data($result, "name") )?>">
				</div>

				<div class="mb-4">
					<label class="form-label"><?php _e("Menu title")?></label>
					<input type="text" name="menu_title" class="form-control form-control-solid" value="<?php _ec( get_data($data, "title") )?>">
				</div>

				<label class="form-label"><?php _e("Menu description")?></label>
				<?php echo view_cell('\Core\Caption\Controllers\Caption::block', ['name' => 'menu_desc', 'placeholder' => __("Enter menu description"), 'value' => get_data($data, "text") ]) ?>

				<div class="mb-4">
					<label class="form-label"><?php _e("Menu footer")?></label>
					<input type="text" name="menu_footer" class="form-control form-control-solid" value="<?php _ec( get_data($data, "footer") )?>">
				</div>

				<div class="mb-4">
					<label class="form-label"><?php _e("Menu button")?></label>
					<input type="text" name="menu_button" class="form-control form-control-solid" value="<?php _ec( get_data($data, "buttonText") )?>">
				</div>
			</div>
		</div>

		<div class="wa-template-section">
		<?php if ($sections): ?>
                    
            <?php foreach ($sections as $key => $section): ?>
                
                <div class="card b-r-6 mb-4 wa-template-section-item" data-count="<?php _ec($key+1)?>">
					<div class="card-header">
						<div class="card-title"><?php _e("Section")?> <?php _ec($key+1)?></div>
					</div>

					<div class="card-body">

						<div class="mb-4">
							<label class="form-label"><?php _e("Section name")?></label>
							<input type="text" name="section_name[<?php _ec($key+1)?>]" class="form-control form-control-solid" value="<?php _e( $section->title )?>">
						</div>

						<label class="form-label mb-3"><?php _e("List option")?></label>

						<div class="wa-template-option">

							<?php 
                                $options = false;
                                if( !empty($section) ){
                                    if( !empty($section) && isset($section->rows) && count($section->rows) != 0 ){
                                        $options = $section->rows;
                                    }
                                }
                            ?>

							<?php foreach ($options as $option_key => $option): ?>
                            <div class="card border b-r-6 mb-4 wa-template-option-item">
								<div class="card-body">
									<div class="mb-4">
										<label class="form-label"><?php _e("Option name")?></label>
										<input type="text" name="options[<?php _e($key+1)?>][name][]" class="form-control form-control-solid" value="<?php _e( $option->title )?>">
									</div>

									<div class="">
										<label class="form-label"><?php _e("Option description")?></label>
										<input type="text" name="options[<?php _e($key+1)?>][desc][]" class="form-control form-control-solid" value="<?php _e( $option->description )?>">
									</div>

								</div>
							</div>
                            <?php endforeach ?>

							

						</div>

					</div>

					<div class="card-footer wa-template-wrap-add">
						<a href="javascript:void(0);" class="btn btn-dark px-3 btn-wa-add-list-option"><?php _e("Add new option")?></a>
					</div>
				</div>

            <?php endforeach ?>

        <?php endif ?>
		</div>

		<div class="mt-5 d-flex justify-content-between">
			<button type="button" class="btn btn-dark w-100 me-2 btn-wa-add-section"><?php _e("Add new section")?></button>
			<button type="submit" class="btn btn-primary w-100 ms-2"><?php _e("Submit")?></button>
		</div>
	</div>
</form>

<div class="wa-template-data-option d-none">
	<div class="card border b-r-6 mb-4 wa-template-option-item">
		<div class="card-header">
			<div class="card-title"><?php _e("Option item")?></div>
			<div class="card-toolbar">
				<button type="button" class="btn btn-sm btn-light-danger px-3 b-r-6 remove-item" data-remove="wa-template-option-item"><i class="fad fa-trash-alt pe-0 me-0"></i></button>
			</div>
		</div>
		<div class="card-body">
			<div class="mb-4">
				<label class="form-label"><?php _e("Option name")?></label>
				<input type="text" name="options[{count}][name][]" class="form-control form-control-solid">
			</div>

			<div class="">
				<label class="form-label"><?php _e("Option description")?></label>
				<input type="text" name="options[{count}][desc][]" class="form-control form-control-solid">
			</div>

		</div>
	</div>
</div>

<div class="wa-template-data-section d-none">
    <div class="card b-r-6 mb-4 wa-template-section-item" data-count="{count}">
		<div class="card-header">
			<div class="card-title"><?php _e("Section")?> {count}</div>
			<div class="card-toolbar">
				<button type="button" class="btn btn-sm btn-light-danger px-3 b-r-6 remove-item" data-remove="wa-template-section-item"><i class="fad fa-trash-alt pe-0 me-0"></i></button>
			</div>
		</div>

		<div class="card-body">
			<div class="mb-4">
				<label class="form-label"><?php _e("Section name")?></label>
				<input type="text" name="section_name[{count}]" class="form-control form-control-solid">
			</div>

			<label class="form-label mb-3"><?php _e("List option")?></label>

			<div class="wa-template-option"></div>

		</div>

		<div class="card-footer wa-template-wrap-add">
			<a href="javascript:void(0);" class="btn btn-dark px-3 btn-wa-add-list-option"><?php _e("Add new option")?></a>
		</div>
	</div>
</div>