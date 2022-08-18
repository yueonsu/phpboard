<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/test/libs/Db.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/test/libs/Crypt.php";
use libs\Db;
use libs\Crypt;

$decoded = json_decode(file_get_contents("php://input"));
$id = $decoded->id;
$email = $decoded->email;

$iuser = mysqli_fetch_assoc(Db::query("SELECT * FROM user WHERE email = '$email' AND id = '$id'"))['iuser'];

if($iuser == null) { echo 0; return; }
$crypt = new Crypt;
$plainPw = sprintf('%06d', rand(000000, 999999));
$pw = $crypt->Encrypt($plainPw, "123456789", "#@$%^&*()_+=-");
Db::query("UPDATE user SET pw = '$pw' WHERE iuser = $iuser");

$sub = "임시 비밀번호";
$con = "임시비밀번호 : " . $plainPw;
$header = "From : yueonsu@gmail.com";

$success = mail($email, $sub, $con, $header);

if(!$success) { echo 2; return; }


echo json_encode($pw);
?>