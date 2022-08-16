<?php
require_once $_SERVER['DOCUMENT_ROOT']."/test/libs/Db.php";
use libs\Db;
$iboard = $_GET['iboard'];
$rowCnt = $_GET['rowCnt'];
$cnt = mysqli_fetch_assoc(Db::query("SELECT COUNT(*) AS cnt FROM comment WHERE iboard=$iboard AND reply is null"))['cnt'];
echo ceil($cnt / $rowCnt);


?>