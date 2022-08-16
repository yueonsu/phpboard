<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/test/libs/Db.php';
use libs\Db;

$decoded = json_decode(file_get_contents("php://input"));
$email = $decoded->email;
$iuser = $decoded->iuser;

$result = Db::query("UPDATE user SET email = '$email' WHERE iuser = $iuser");

echo json_encode($result);
?>