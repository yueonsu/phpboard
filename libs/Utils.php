<?php

namespace libs;

class Utils {
	
	static function replaceNewLine($str) {
		return str_replace("\n", "<br/>", $str);
	}
	
	static function title($str) {
        $str = str_replace("<", "&lt;", $str);
		if(mb_strlen($str, "UTF-8") > 20) {
			$str = mb_substr($str, 0, 20, "UTF-8") . "...";
		}

		return $str;
	}

    static function write($str) {
        return str_replace("'", "&#039;", $str);
    }

    static function getContent($str) {
        return str_replace("<", "&lt;", $str);
    }


}

?>