<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/test/libs/Crypt.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/test/libs/Db.php';
use libs\Crypt;
use libs\Db;



$id = $_POST['id'];
$pw = $_POST['pw'];
$nm = $_POST['nm'];
$email = $_POST['email'];

$crypt = new Crypt();
$pw = $crypt->Encrypt($pw, "123456789", "#@$%^&*()_+=-");

$result = Db::query("insert into user (id, pw, nm, email) values ('$id', '$pw', '$nm', '$email')");

if($result) {
    header("Location:/test/board/main.php");
} else {
    header("Location:/test/user/join.php");
}
?>
