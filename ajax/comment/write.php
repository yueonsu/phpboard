<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/test/libs/Db.php';
use libs\Db;
	
$iuser = $_POST['iuser'];
$iboard = $_POST['iboard'];
$content = $_POST['content'];
$secret = $_POST['secret'] == 1 ? 1 : 0;


echo $iuser . "<br/>";
echo $iboard . "<br/>";
echo $content . "<br/>";
echo $secret;

if(mb_strlen($content) < 100) {
	Db::query("INSERT INTO comment (iuser, iboard, content, secret) VALUES ($iuser, $iboard, '$content', $secret)");
}

header("Location:/test/detail.php?iboard=$iboard");
?>