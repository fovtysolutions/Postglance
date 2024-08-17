<div class="mb-3">
	<label class="form-label fs-12 fw-400"><?php _e("Title")?></label>
	<div class="input-group input-group-solid bg-white border">
        <input type="text" class="form-control" name="advance_options[youtube_title]" placeholder="<?php _e("Enter title")?>">
    </div>
</div>
<div class="mb-3">
	<label class="form-label fs-12 fw-400"><?php _e("Category")?></label>
	<select class="form-select" name="advance_options[youtube_category]">
        <option value="0"><?php _e('Select a category')?></option>
        <option value="1"><?php _e('Film & Animation')?></option>
        <option value="2"><?php _e('Autos & Vehicles')?></option>
        <option value="10"><?php _e('Music')?></option>
        <option value="15"><?php _e('Pets & Animals')?></option>
        <option value="17"><?php _e('Sports')?></option>
        <option value="19"><?php _e('Travel & Events')?></option>
        <option value="20"><?php _e('Gaming')?></option>
        <option value="22"><?php _e('People & Blogs')?></option>
        <option value="23"><?php _e('Comedy')?></option>
        <option value="24"><?php _e('Entertainment')?></option>
        <option value="25"><?php _e('News & Politics')?></option>
        <option value="26"><?php _e('Howto & Style')?></option>
        <option value="27"><?php _e('Education')?></option>
        <option value="28"><?php _e('Science & Technology')?></option>
        <option value="29"><?php _e('Nonprofits & Activism')?></option>
    </select>
</div>
<div class="mb-3">
	<label class="form-label fs-12 fw-400"><?php _e("Tags")?></label>
	<input type="text" class="form-control" name="advance_options[youtube_tags]" data-role="tagsinput" placeholder="<?php _e("Enter tags")?>">
</div>