<?php 
include_once $_SERVER['DOCUMENT_ROOT'].'/test/libs/Db.php';
use libs\Db;
$email = $_GET['email'];
$num = sprintf('%06d', rand(000000, 999999));
$content = " 인증번호 : ". $num;
$subject = "인증번호 : $num";
$headers = "From: yueonsu@gmail.com";

$result = 0;

$isEmail = mysqli_fetch_assoc(Db::query("SELECT * FROM user WHERE email = '$email'"));
if($isEmail == null) {
	$result = 1;
}

$success = mail($email, $subject, $content, $headers);
if(!$success || !preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email)) {
	$result = 0;
}

if($result == 1) {
	session_start();
	$_SESSION['num'] = $num;
}

echo json_encode($result);
?>