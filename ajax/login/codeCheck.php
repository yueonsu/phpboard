<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/test/libs/Db.php";
use libs\Db;

session_start();
$certificationNum = $_SESSION['num'];
$code = $_GET['num'];
$email = $_GET['email'];

$result = $certificationNum == $code ? true : false;

if($result) {
    $result = mysqli_fetch_assoc(Db::query("SELECT id FROM user WHERE email='$email'"))['id'];
    unset($_SESSION['num']);
} else {
    $result = false;
}

echo json_encode($result);
?>
