<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . '/test/libs/Db.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/test/libs/Crypt.php';
use libs\Crypt;
use libs\Db;

$c = new Crypt();
$decoded = json_decode(file_get_contents("php://input"));

$iuser = $decoded->iuser;
$pw = $decoded->pw;
$pw = $c->Encrypt($pw, "123456789", "#@$%^&*()_+=-");

$result = Db::query("UPDATE user SET pw = '$pw' WHERE iuser = $iuser");

echo json_encode($result);
?>