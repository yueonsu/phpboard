<?php

namespace libs;

class Crypt {
	function Encrypt($str, $secret_key, $secret_iv)
	{
		$key = hash('sha256', $secret_key);
		$iv = substr(hash('sha256', $secret_iv), 0, 16)    ;
		
		return str_replace("=", "", base64_encode(openssl_encrypt($str, "AES-256-CBC", $key, 0, $iv)));
	}
	
	
	function Decrypt($str, $secret_key, $secret_iv)
	{
		$key = hash('sha256', $secret_key);
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
		
		return openssl_decrypt(base64_decode($str), "AES-256-CBC", $key, 0, $iv);
	}
}

