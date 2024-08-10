<?php
$language_default = (object)["dir" => "ltr", "name" => "English", "code" => "en", "icon" => "flag-icon flag-icon-us"];
if(get_session('language') && get_session('language') != "null"){
	$language = json_decode( get_session('language') );
	if($language == ""){
		$language = $language_default;
	}
    $request->language = $language;
}else{
	if(get_user("language")){
		$code = get_user("language");
		$language = db_get("*", TB_LANGUAGE_CATEGORY, ["code" => $code]);
		if(empty($language)){
			$language = db_get("*", TB_LANGUAGE_CATEGORY, ["is_default" => 1]);
		}
	}else{
		$language = db_get("*", TB_LANGUAGE_CATEGORY, ["is_default" => 1]);
	}
	
	if(!$language){
		$language = $language_default;
	}
    
    $language = json_encode($language);
    if(!empty($language)){
        set_session(["language" => $language]);
    }else{
    	$language = $language_default;
    }

    $request->language = json_decode($language);
}

if ( post("refresh_language") ) {
	$module_paths = get_module_paths();
	$list_items = [];
	if(!empty($module_paths))
	{
	    if( !empty($module_paths) ){
	        foreach ($module_paths as $key => $module_path) {
	            $config_path = $module_path . "/Config.php";
	            $config_item = include $config_path;

	            $module_path = $module_path . "/";
	            $module_files = glob( $module_path . '*' );

	            $all_langs = [];

	            $all_files = getDirContents($module_path);

	            foreach ($all_files as $key => $file) {
	            	if(is_file($file)){
	            		$file_content = file_get_contents($file);
	            		if( stripos($file, "Config.php") ){
							preg_match_all("/\'name\'\ \=\>\ \'(.*)\'\,|\"name\"\ \=\>\ \"(.*)\"\,/U", $file_content, $out);
							foreach ($out as $key => $langs) {
								$langs = array_filter($langs);
								if($key != 0 && !empty($langs)){
									$all_langs = array_merge($langs, $all_langs);
								}
							}

							preg_match_all("/\'desc\'\ \=\>\ \'(.*)\'\,|\"desc\"\ \=\>\ \"(.*)\"\,/U", $file_content, $out);
							foreach ($out as $key => $langs) {
								$langs = array_filter($langs);
								if($key != 0 && !empty($langs)){
									$all_langs = array_merge($langs, $all_langs);
								}
							}
						}else{
							preg_match_all("/_e\(\"(.*)\"\)|_e\(\'(.*)\'\)|__\(\"(.*)\"\)|__\(\'(.*)\'\)|_e\(\s\"(.*)\"\s\)/U", $file_content, $out);
							foreach ($out as $key => $langs) {
								$langs = array_filter($langs);
								if($key != 0 && !empty($langs)){
									$all_langs = array_merge($langs, $all_langs);
								}
							}
						}

	            	}
	            }

	            $new_all_langs = [];
	            foreach ($all_langs as $key => $value) {
	            	$new_all_langs[$value] = $value;
	            }
	            
	            create_folder($module_path."Language/");
	            $lang_file = $module_path."Language/Language.php";
	            if( file_exists($lang_file) ){
	            	unlink($lang_file);
	            }
	            file_put_contents($lang_file, '<?php return ' . var_export($new_all_langs, true) . ';');
	        }
	    }
	}
}

if(uri("segment", 1) == "" || uri("segment", 1) == "dashboard"){
	$language_categories = db_fetch("*", TB_LANGUAGE_CATEGORY);
	if($language_categories){
		foreach ($language_categories as $key => $language_category) {
			
			
			if( !file_exists(WRITEPATH."lang/".$language_category->code.".json") ){
				/*EXPORT LANGUAGE*/
		        $language_items = db_fetch("slug, text", TB_LANGUAGE, ["code" => $language_category->code]);
		        if(!empty($language_category)){
		            $language = array();
		            if(!empty($language_items)){
		                foreach ($language_items as $key => $value) {
		                    $language[$value->slug] = $value->text;
		                }
		            }

		            $category = [
		                "name"        => $language_category->name,
		                "icon"        => $language_category->icon,
		                "code"        => $language_category->code
		            ];

		            $language_pack = [
		                "info" => $language_category,
		                "data" => $language
		            ];

		            $language_pack = json_encode($language_pack);

		            create_folder(WRITEPATH."lang");
		            $handle = fopen(WRITEPATH."lang/".$language_category->code.".json", "w");
		            fwrite($handle, $language_pack);
		            fclose($handle);
		        }
		        /*END EXPORT LANGUAGE*/
			}
		}
	}
}
