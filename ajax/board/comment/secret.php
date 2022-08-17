<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/test/libs/Db.php';
use libs\Db;

session_start();
$iuser = $_SESSION['iuser'];
$icmt = $_GET['icmt'];
$secret = $_GET['secret'];

$result = Db::query("UPDATE comment SET secret = $secret WHERE iuser = $iuser AND icmt = $icmt");

if(!$result) {
	return;
}
echo $secret;
?>