<div class="mb-5">
    <label class="form-label text-primary text-uppercase"><?php _e("Features")?></label>
    <div class="mb-3">
        <label for="whatsapp_profile" class="form-label"> 
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="permissions[whatsapp_profile]" id="whatsapp_profile" value="1" <?php _e( plan_permission('checkbox', "whatsapp_profile") == 1?"checked":"" )?>>
                <label class="form-check-label" for="whatsapp_profile"><?php _e("Profile")?></label>
            </div>
        </label>

        <label for="whatsapp_bulk" class="form-label"> 
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="permissions[whatsapp_bulk]" id="whatsapp_bulk" value="1" <?php _e( plan_permission('checkbox', "whatsapp_bulk") == 1?"checked":"" )?>>
                <label class="form-check-label" for="whatsapp_bulk"><?php _e("Bulk messaging")?></label>
            </div>
        </label>

        <label for="whatsapp_autoresponder" class="form-label"> 
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="permissions[whatsapp_autoresponder]" id="whatsapp_autoresponder" value="1" <?php _e( plan_permission('checkbox', "whatsapp_autoresponder") == 1?"checked":"" )?>>
                <label class="form-check-label" for="whatsapp_autoresponder"><?php _e("Autoresponder")?></label>
            </div>
        </label>

        <label for="whatsapp_chatbot" class="form-label"> 
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="permissions[whatsapp_chatbot]" id="whatsapp_chatbot" value="1" <?php _e( plan_permission('checkbox', "whatsapp_chatbot") == 1?"checked":"" )?>>
                <label class="form-check-label" for="whatsapp_chatbot"><?php _e("Chatbot")?></label>
            </div>
        </label>

        <label for="whatsapp_export_participants" class="form-label"> 
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="permissions[whatsapp_export_participants]" id="whatsapp_export_participants" value="1" <?php _e( plan_permission('checkbox', "whatsapp_export_participants") == 1?"checked":"" )?>>
                <label class="form-check-label" for="whatsapp_export_participants"><?php _e("Export participants")?></label>
            </div>
        </label>

        <label for="whatsapp_contact" class="form-label"> 
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="permissions[whatsapp_contact]" id="whatsapp_contact" value="1" <?php _e( plan_permission('checkbox', "whatsapp_contact") == 1?"checked":"" )?>>
                <label class="form-check-label" for="whatsapp_contact"><?php _e("Contacts")?></label>
            </div>
        </label>
        <?php if (find_modules("whatsapp_api")): ?>
        <label for="whatsapp_api" class="form-label"> 
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="permissions[whatsapp_api]" id="whatsapp_api" value="1" <?php _e( plan_permission('checkbox', "whatsapp_api") == 1?"checked":"" )?>>
                <label class="form-check-label" for="whatsapp_api"><?php _e("API")?></label>
            </div>
        </label>
        <?php endif ?>
    </div>
</div>

<div class="mb-5">
    <label class="form-label text-primary text-uppercase"><?php _e("Message Type")?></label>
    <div class="mb-3">
        <label for="whatsapp_button_template" class="form-label"> 
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="permissions[whatsapp_button_template]" id="whatsapp_button_template" value="1" <?php _e( plan_permission('checkbox', "whatsapp_button_template") == 1?"checked":"" )?>>
                <label class="form-check-label" for="whatsapp_button_template"><?php _e("Send button message")?></label>
            </div>
        </label>

        <label for="whatsapp_list_message_template" class="form-label"> 
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="permissions[whatsapp_list_message_template]" id="whatsapp_list_message_template" value="1" <?php _e( plan_permission('checkbox', "whatsapp_list_message_template") == 1?"checked":"" )?>>
                <label class="form-check-label" for="whatsapp_list_message_template"><?php _e("Send list message")?></label>
            </div>
        </label>

        <label for="whatsapp_send_media" class="form-label"> 
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="permissions[whatsapp_send_media]" id="whatsapp_send_media" value="1" <?php _e( plan_permission('checkbox', "whatsapp_send_media") == 1?"checked":"" )?>>
                <label class="form-check-label" for="whatsapp_send_media"><?php _e("Send media message")?></label>
            </div>
        </label>
    </div>
</div>


<div class="mb-5">
    <label class="form-label text-primary text-uppercase"><?php _e("Autoresponder")?></label>
    <div class="mb-3">
        <label class="form-label" for="whatsapp_autoresponser_delay"><?php _e("Minimum number of minutes to choose autoresponder delay")?></label>
        <input type="number" class="form-control" id="whatsapp_autoresponser_delay" name="permissions[whatsapp_autoresponser_delay]" value="<?php _ec( (int)plan_permission('text', "whatsapp_autoresponser_delay") )?>">
    </div>
</div>

<div class="mb-5">
    <label class="form-label text-primary text-uppercase"><?php _e("Chatbot")?></label>
    <div class="mb-3">
        <label class="form-label" for="whatsapp_chatbot_item_limit"><?php _e("Item limit for chatbots on each account")?></label>
        <input type="number" class="form-control" id="whatsapp_chatbot_item_limit" name="permissions[whatsapp_chatbot_item_limit]" value="<?php _ec( (int)plan_permission('text', "whatsapp_chatbot_item_limit") )?>">
    </div>
</div>

<div class="mb-5">
    <label class="form-label text-primary text-uppercase"><?php _e("Bulk messaging")?></label>
    <div class="mb-3">
        <label for="whatsapp_bulk_schedule_by_times" class="form-label"> 
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="permissions[whatsapp_bulk_schedule_by_times]" id="whatsapp_bulk_schedule_by_times" value="1" <?php _e( plan_permission('checkbox', "whatsapp_bulk_schedule_by_times") == 1?"checked":"" )?>>
                <label class="form-check-label" for="whatsapp_bulk_schedule_by_times"><?php _e("Schedule by times")?></label>
            </div>
        </label>
    </div>
    <div class="mb-3">
        <label class="form-label" for="whatsapp_bulk_max_run"><?php _e("The maximum number of bulk messaging campaign can run at the same time")?></label>
        <input type="number" class="form-control" id="whatsapp_bulk_max_run" name="permissions[whatsapp_bulk_max_run]" value="<?php _ec( (int)plan_permission('text', "whatsapp_bulk_max_run") )?>">
    </div>
    <div class="mb-3">
        <label class="form-label" for="whatsapp_bulk_max_contact_group"><?php _e("The maximum number of contact groups")?></label>
        <input type="number" class="form-control" id="whatsapp_bulk_max_contact_group" name="permissions[whatsapp_bulk_max_contact_group]" value="<?php _ec( (int)plan_permission('text', "whatsapp_bulk_max_contact_group") )?>">
    </div>
    <div class="mb-3">
        <label class="form-label" for="whatsapp_bulk_max_phone_numbers"><?php _e("The maximum number of numbers that can be added to the contact group")?></label>
        <input type="number" class="form-control" id="whatsapp_bulk_max_phone_numbers" name="permissions[whatsapp_bulk_max_phone_numbers]" value="<?php _ec( (int)plan_permission('text', "whatsapp_bulk_max_phone_numbers") )?>">
    </div>
</div>

<div class="mb-5">
    <label class="form-label text-primary text-uppercase"><?php _e("Total number of messages/month")?></label>
    <div class="mb-3">
        <input type="number" class="form-control" id="whatsapp_message_per_month" name="permissions[whatsapp_message_per_month]" value="<?php _ec( (int)plan_permission('text', "whatsapp_message_per_month") )?>">
        <span class="fs-12 text-primary"><?php _e("Include the total number of messages sent by Bulk messaging, Autoresponser, Chatbot")?></span>
    </div>
</div>