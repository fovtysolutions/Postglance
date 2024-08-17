<li class="nav-item me-0">
     <label for="type_template" class="nav-link bg-active-primary text-gray-700 px-4 py-3 b-r-6 text-active-white <?php _ec( get_data($result, "type") == 3?"active":"" ) ?>" data-bs-toggle="pill" data-bs-target="#wa_list_message" type="button" role="tab"><?php _e("List messages")?></label>
     <input class="d-none" type="radio" name="type" id="type_template" <?php _ec( (get_data($result, "type") == 3)?"checked='true'":"" ) ?> value="3">
</li>