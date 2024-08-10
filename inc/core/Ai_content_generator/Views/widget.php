<?php if ( get_option("openai_status", 0) && permission("openai_content") && permission("openai") ): ?>
<li>
	<a href="<?php _e( base_url("ai_content_generator/popup/".$name) )?>" class="actionItem px-3 py-2 d-block btn btn-active-light text-gray-700" data-popup="Ai_content_generatorModal" title="<?php _e("AI Content Generator")?>" data-toggle="tooltip" data-placement="top"><i class="icon icon-openai pe-0"></i></a>
</li>
<?php endif ?>