<div class="mb-4">
    <h3 class="mb-0"><?php _e("Results")?></h3>
    <span class="small"><?php _e( sprintf(__("%s results in this feed"), !empty($result)?count($result->data->choices):0) )?></span>
</div>

<div class="aig-results">
	<?php if (!empty($result)): ?>
		<ul class="p-l-0">
			<?php foreach ($result->data->choices as $key => $choice): ?>
	        <li class="mb-3">
	            <a class="text-gray-800 border b-r-10 p-20 bg-hover-light-primary d-block position-relative p-l-45 aig-user-content" href="<?php _ec( base_url("post")."?caption=".base64_encode(convert_emoji_to_unicode($choice->message->content)) )?>">
	            	<div class="text-success fs-40 position-absolute opacity-25 l-5 t-0">
		        		<i class="fad fa-quote-left"></i>
		        	</div>
	                <span><?php _e($choice->message->content)?></span>
	            </a>
	        </li>
			<?php endforeach ?>
	    </ul>

	<?php else: ?>
		<div class="mw-400 container d-flex align-items-center align-self-center h-100">
		    <div>
		        <div class="text-center px-4">
		            <img class="mw-100 mh-300px" alt="" src="<?php _e( get_theme_url() ) ?>Assets/img/empty.png">
		        </div>
		    </div>
		</div>
	<?php endif ?>
    
</div>