<li class="nav-item me-0">
     <label for="type_button" class="nav-link bg-active-primary text-gray-700 px-4 py-3 b-r-6 text-active-white <?php _ec( get_data($result, "type") == 2?"active":"" ) ?>" data-bs-toggle="pill" data-bs-target="#wa_button" type="button" role="tab"><?php _e("Buttons")?></label>
     <input class="d-none" type="radio" name="type" id="type_button" <?php _ec( (get_data($result, "type") == 2)?"checked='true'":"" ) ?> value="2">
</li>