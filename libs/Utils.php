<?php

namespace libs;

class Utils {
	
	static function replaceNewLine($str) {
		return str_replace("\n", "<br/>", $str);
	}
	
	static function title($str) {
		if(mb_strlen($str, "UTF-8") > 20) {
			$str = mb_substr($str, 0, 20, "UTF-8") . "...";
		}
		
		return $str;
	}
	
	static function preventScript($str) {
		$str = str_replace("\"", "&quot;", 
			   str_replace("'", "&#039;", 
			   str_replace(">", "&gt;", 
			   str_replace("<", "&lt;", $str))));
		return $str;
	}
	
	static function getHitCount($iboard) {
		return mysqli_fetch_assoc(Db::query("SELECT COUNT(*) AS hit FROM hit WHERE iboard = $iboard"))['hit'];
	}
}

?>