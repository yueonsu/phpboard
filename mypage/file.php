<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/test/libs/FileUtils.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/test/libs/Db.php";
use libs\FileUtils;
use libs\Db;

$iuser = $_POST['iuser'];
if($iuser == 0) {
    return;
}

$fu = new FileUtils;
$file = $_FILES['img'];

$path = $_SERVER['DOCUMENT_ROOT'] . "/test/static/img/" . $iuser ."/";
$uuid = $fu->getUuid();
$resultNm = $uuid . "." . $fu->getExt($file['name']);
$fu->makeFolder($path);
move_uploaded_file($file['tmp_name'], $path . $resultNm);

$repreCnt = mysqli_num_rows(Db::query("SELECT iphoto FROM photos WHERE iuser = $iuser AND repre = true"));
$repre = $repreCnt == 0 ? 1 : 0;

Db::query("INSERT INTO photos (img, iuser, repre) VALUES ('$resultNm', $iuser, $repre)");

header("Location:./profile.php?iuser=$iuser");
?>
