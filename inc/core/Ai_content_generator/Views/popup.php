<div class="modal fade aig-modal" id="Ai_content_generatorModal" data-name="<?php _ec($name)?>" tabindex="-1" role="dialog">
  	<div class="modal-dialog modal-xl modal-dialog-centered">
	    <div class="modal-content">
    	
      		<div class="modal-header">
		        <h5 class="modal-title d-flex justify-content-center align-items-center"><i class="<?php _ec( $config['icon'] )?> me-2" style="color: <?php _ec( $config['color'] )?>;"></i> <?php _ec("AI Generate Content")?></h5>
		         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      	</div>
	      	<div class="modal-body shadow-none p-0">
			    <div class="card b-r-0 card-shadow d-body p-0 border">
			            <div class="row">
			                <div class="col-md-4 p-r-0">
			                    <div class="card b-r-0 shadow-none">
			                        <div class="card-body p-0">
			                            <div class="mb-3 mt-3 p-l-20 p-r-20 aig-headline">
			                                <span class="inactive"><?php _e("Prompt templates")?></span>
			                                <a class="active fw-bold d-none text-gray-900" href="javascript:void(0);"><i class="far fa-angle-left pe-2"></i> <?php _e("Prompt templates")?></a>
			                            </div>
			                            <?php if ( !empty($result) ): ?>
			                            <div class="aig-scroll n-scroll h-550 p-l-20 p-r-15 flex-shrink-1 flex-grow-1 flex-basis-1 overflow-auto">
			                                <?php if ( !empty($templates) ): ?>
			                                <div class="aig-list-items d-none">
			                                    <div class="d-flex mb-3 w-100">
			                                        <div class="d-flex align-items-center w-lg-400px w-100">
			                                            <form class="w-100 position-relative ">
			                                                <div class="input-group sp-input-group">
			                                                  <span class="input-group-text bg-light border-0 fs-20 bg-gray-100 text-gray-800" id="sub-menu-search"><i class="fad fa-search"></i></span>
			                                                  <input type="text" class="form-control form-control-solid ps-15 bg-light border-0 search-input" data-search="group-item" name="search" value="" placeholder="<?php _e("Search")?>" autocomplete="off">
			                                                </div>
			                                            </form>
			                                        </div>
			                                    </div>
			                                    <div class="aig-choice fw-bold mb-4 fs-16">
			                                        <i class="icon"></i>
			                                        <span class="name ps-1"></span>
			                                    </div>
			                                    <ul>
			                                        <?php foreach ($templates as $key => $value): ?>
			                                        <li data-pid="<?php _e($value->pid)?>" class="group-item"><a href="javascript:void(0);" class="mb-3 pb-3 text-dark d-block border-bottom"><?php _e($value->content)?></a></li>
			                                        <?php endforeach ?>
			                                    </ul>
			                                </div>
			                                <?php endif ?>
			                                <div class="aig-categories">
			                                    <div class="row d-flex">
			                                        <?php foreach ($result as $key => $value): ?>
			                                            <div class="col-md-4 col-sm-6 mb-4 p-l-5 p-r-5">
			                                                <div class="sp-menu-item group-item b-r-4 p-12 border h-100">
			                                                    <a class="ps-4 pe-4 item" href="javascript:void(0);" data-pid="<?php _ec( get_data($value, "id") )?>" data-name="<?php _ec( get_data($value, "name") )?>" data-icon="<?php _ec( get_data($value, "icon") )?>" data-color="<?php _ec( get_data($value, "color") )?>">
			                                                        <div class="mb-10 me-auto">
			                                                            <div class="mb-4">
			                                                                <div class="w-40 h-40 m-r-10">
			                                                                    <div class="border rounded h-40 fs-18 d-flex align-items-center justify-content-center text-dark b-r-10"><i class="<?php _ec( get_data($value, "icon") )?>" style="color: <?php _ec( get_data($value, "color") )?>"></i></div>
			                                                                </div>
			                                                            </div>
			                                                            <div class="d-flex flex-column flex-grow-1">
			                                                                <h5 class="custom-list-title fw-bold text-gray-800 mb-1 fs-12"><?php _ec( get_data($value, "name") )?></h5>
			                                                            </div>
			                                                        </div>
			                                                    </a>
			                                                </div>
			                                            </div>
			                                        <?php endforeach ?>
			                                    </div>
			                                </div>
			                            </div>


			                        <?php else: ?>
			                            <div class="d-flex flex-column justify-content-center align-items-center text-gray-500 h-100 mih-300">
			                                <img class="mh-190 mb-4" alt="" src="<?php _e( get_theme_url() ) ?>Assets/img/empty2.png">
			                               <div>
			                                    <a class="btn btn-primary btn-sm b-r-30" href="<?php _e( get_module_url("index/update") )?>" >
			                                        <i class="fad fa-plus"></i> <?php _e("Add new")?>
			                                    </a>
			                                </div>
			                            </div>
			                        <?php endif ?>
			                        </div>
			                    </div>
			                </div>
			                <div class="col-md-4 border-end border-start p-r-0 p-l-0">
			                    <div class="card b-r-0 shadow-none pb-4">
			                        <div class="card-body p-0">
			                            <form class="actionForm" action="<?php _ec( get_module_url("generate") ) ?>" method="POST" data-result="html" data-content="aig-block-results">
			                                <div class="n-scroll mh-600 p-l-20 p-r-15">
			                                    <div class="mb-3 mt-3">
			                                        <label for="prompt" class="form-label fw-4 mb-3"><?php _e("Your prompt")?></label>
			                                        <textarea class="form-control h-120" name="prompt"><?php _ec( get_data($result, "content") )?></textarea>
			                                    </div>
			                                    <div class="row">
			                                        <div class="col-md-6">
			                                            <div class="mb-3">
			                                                <label class="fs-12 mb-1"><?php _e("Language")?></label>
			                                                <select class="form-select bg-white border form-select-sm" data-control="select2" name="language" required="">
			                                                    <?php foreach (languages() as $key => $value): ?>
			                                                        <option value="<?php _ec($key)?>" <?php _ec( get_option("openai_default_language", "en-US")==$key?"selected":"" ) ?> ><?php _e($value)?></option>
			                                                    <?php endforeach ?>
			                                                </select>
			                                            </div>
			                                        </div>
			                                        <div class="col-md-6">
			                                            <div class="mb-3">
			                                                <label class="fs-12 mb-1"><?php _e("Approximate words")?></label>
			                                                <input type="number" class="form-control form-control-sm" name="maximum_length" value="<?php _ec( get_option("openai_default_max_output_lenght", "50") ) ?>" required="">
			                                            </div>
			                                        </div>
			                                        <div class="col-md-6">
			                                            <div class="mb-3">
			                                                <label class="fs-12 mb-1"><?php _e("Tone of voice")?></label>
			                                                <select class="form-select bg-white border form-select-sm" data-control="select2" name="tone_of_voice" required="">
			                                                    <?php foreach (tone_of_voices() as $key => $value): ?>
			                                                        <option value="<?php _ec($key)?>" <?php _ec( get_option("openai_default_tone_of_voice", "Polite")==$key?"selected":"" ) ?>><?php _e($value)?></option>
			                                                    <?php endforeach ?>
			                                                </select>
			                                            </div>
			                                        </div>
			                                        <div class="col-md-6">
			                                            <div class="mb-3">
			                                                <label class="fs-12 mb-1"><?php _e("Creativity")?></label>
			                                                <select class="form-select bg-white border form-select-sm" data-control="select2" name="creativity" required="">
			                                                    <?php foreach (openai_creativity() as $key => $value): ?>
			                                                        <option value="<?php _ec($key)?>" <?php _ec( get_option("openai_default_creativity", "0.75")==$key?"selected":"" ) ?>><?php _e($value)?></option>
			                                                    <?php endforeach ?>
			                                                </select>
			                                            </div>
			                                        </div>

			                                        <div class="col-md-6">
			                                            <div class="mb-3">
			                                                <label class="fs-12 mb-1"><?php _e("Add hashtags")?></label>
			                                                <select class="form-select bg-white border form-select-sm" data-control="select2" name="hashtags">
			                                                    <option value=""><?php _e("Disable")?></option>
			                                                    <?php for ($i=1; $i <= 10; $i++): ?>
			                                                        <option value="<?php _ec($i)?>"><?php _ec( $i )?></option>
			                                                    <?php endfor;?>
			                                                </select>
			                                            </div>
			                                        </div>

			                                        <div class="col-md-6">
			                                            <div class="mb-3">
			                                                <label class="fs-12 mb-1"><?php _e("Result number")?></label>
			                                                <select class="form-select bg-white border form-select-sm" data-control="select2" name="n">
			                                                    <?php for ($i=1; $i <= 10; $i++): ?>
			                                                        <option value="<?php _ec($i)?>" <?php _ec($i==3?"selected='true'":"")?> ><?php _ec( $i )?></option>
			                                                    <?php endfor;?>
			                                                </select>
			                                            </div>
			                                        </div>

			                                        <div class="col-md-12">
			                                            <button class="btn btn-dark d-block btn-sm"><?php _e("Generate")?></button>
			                                        </div>
			                                    </div>
			                                </div>
			                            </form>
			                        </div>
			                    </div>
			                </div>
			                <div class="col-md-4 p-l-0">
			                    <div class="card b-r-0 shadow-none">
			                        <div class="card-body p-20 n-scroll mh-600 aig-block-results">
			                            <h3 class="mb-4"><?php _e("Get started")?></h3>

			                            <ol class="p-l-11">
			                                <li class="mb-3"><?php _e("Initiate the process by selecting a prompt from the <strong>Prompt Templates</strong> panel on the left side. You can either utilize the button for a random prompt or create one manually.", false)?></li>
			                                <li class="mb-3"><?php _e("Craft or modify your prompt to specify what you want the AI to generate. Click the <strong>Generate</strong> button to commence the generation process.", false)?></li>
			                                <li class="mb-3"><?php _e("A total of five results have been generated for your prompt.", false)?></li>
			                            </ol>  
			                        </div>
			                    </div>
			                </div>
			            </div>
			        </div>
			    </div>
	      	</div>
	    </div>
  	</div>
</div>