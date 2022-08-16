<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/test/libs/Db.php';
use libs\Db;

$id = $_GET['id'];

$result = mysqli_num_rows(Db::query("SELECT * FROM user WHERE id = '$id'"));
$isId = $result > 0 ? false : true;

echo json_encode($isId);
?>