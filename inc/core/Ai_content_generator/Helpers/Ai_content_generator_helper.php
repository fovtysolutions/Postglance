<?php 
if(!function_exists("stripEmojis")){
	function stripEmojis($string) {
	  $string = str_replace("?", "{%}", $string);
	  $string = mb_convert_encoding($string, "ISO-8859-1", "UTF-8");
	  $string = mb_convert_encoding($string, "UTF-8", "ISO-8859-1");
	  $string = preg_replace('/(\s?\?\s?)/', ' ', $string);
	  $string = str_replace("{%}", "?", $string);
	  return trim($string);
	}
}

if(!function_exists("emoji_to_unicode")){
	function emoji_to_unicode($emoji) {
	   $emoji = mb_convert_encoding($emoji, 'UTF-32', 'UTF-8');
	   $unicode = strtoupper(preg_replace("/0{3}1/"," U+1",bin2hex($emoji)));
	  return $unicode;
	}
}

if(!function_exists("convert_emoji_to_unicode")){
	function convert_emoji_to_unicode($text) {
	    $str = preg_replace_callback(
	        "%(?:\xF0[\x90-\xBF][\x80-\xBF]{2} | [\xF1-\xF3][\x80-\xBF]{3} | \xF4[\x80-\x8F][\x80-\xBF]{2})%xs",
	        function($emoji){
	            $emojiStr = mb_convert_encoding($emoji[0], 'UTF-32', 'UTF-8');
	            return strtoupper(preg_replace("/^[0]+/","U+",bin2hex($emojiStr)));
	        },
	        $text
	    );
	    return $str;
	}
}