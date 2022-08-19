<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/test/libs/Db.php";
use libs\Db;
session_start();

$iphoto = $_GET['iphoto'];
$iuser = $_SESSION['iuser'];
$status = $_GET['repre'];

if($status == 1) {
    if(mysqli_num_rows(Db::query("SELECT * FROM photos WHERE iuser = $iuser")) > 0) {
        Db::query("UPDATE photos SET repre = false");
    }
    echo Db::query("UPDATE photos SET repre = true WHERE iphoto = $iphoto");
} else if($status == 0) {
    echo Db::query("UPDATE photos SET repre = false");
}

?>
