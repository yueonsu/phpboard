<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/test/libs/Db.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/test/libs/Email.php";
use libs\Email;
use libs\Db;
$decoded = json_decode(file_get_contents("php://input"));

$email = $decoded->email;
$nm = $decoded->nm;

$result = mysqli_num_rows(Db::query("SELECT * FROM user WHERE email ='$email' AND nm = '$nm'"));

if($result > 0) {
    $num = sprintf('%06d', rand(000000, 999999));
    $content = " 인증번호 : ". $num;
    $subject = "인증번호 : $num";
    $headers = "From: yueonsu@gmail.com";

    session_start();
    $_SESSION['num'] = $num;
    $result = mail($email, $subject, $content, $headers);
}

echo $result;
?>
