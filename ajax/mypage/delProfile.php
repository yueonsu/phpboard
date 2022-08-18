<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/test/libs/Db.php";
use libs\Db;
session_start();

$decoded = json_decode(file_get_contents("php://input"));
$photoArr = $decoded->result;
$iuser = $_SESSION['iuser'];

$len = count($photoArr);
$cnt = 0;

foreach($photoArr as $val) {
    $img = mysqli_fetch_assoc(Db::query("SELECT * FROM photos WHERE iphoto = $val"))['img'];
    unlink($_SERVER['DOCUMENT_ROOT'] . "/test/static/img/". $iuser . "/" . $img);
    $cnt += Db::query("DELETE FROM photos WHERE iphoto = $val AND iuser = $iuser");
}



$result = $len == $cnt ? 1 : 0;

echo $result;
?>

