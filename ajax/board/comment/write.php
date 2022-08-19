<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/test/libs/Db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/test/libs/Utils.php";
use libs\Utils;
use libs\Db;
	
$iuser = $_POST['iuser'];
$iboard = $_POST['iboard'];
$content = Utils::write($_POST['content']);

if(mb_strlen($content) < 100) {
	Db::query("INSERT INTO comment (iuser, iboard, content) VALUES ($iuser, $iboard, '$content')");
}

header("Location:/test/board/detail.php?iboard=$iboard");
?>