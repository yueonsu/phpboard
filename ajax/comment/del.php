<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/test/libs/Db.php';
use libs\Db;

session_start();

$iuser = $_SESSION['iuser'];
$icmt = $_GET['icmt'];

$result = Db::query("DELETE FROM comment WHERE iuser = $iuser AND icmt = $icmt");
Db::query("DELETE FROM comment WHERE reply = $icmt");

echo $result;
?>