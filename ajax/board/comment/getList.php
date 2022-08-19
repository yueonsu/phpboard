<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/test/libs/Db.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/test/libs/Utils.php';
use libs\Utils;
use libs\Db;

$iboard = $_GET['iboard'];
$startIdx = $_GET['startIdx'];
$rowCnt = $_GET['rowCnt'];

$res = Db::query("SELECT A.*, B.nm FROM comment A INNER JOIN user B ON A.iuser = B.iuser WHERE A.iboard = $iboard AND reply is null ORDER BY A.rdt DESC LIMIT $startIdx, $rowCnt");

$result = array();
while($row = mysqli_fetch_array($res)) {
    array_push($result, array('icmt'=>$row[0], 'iuser'=>$row[1], 'iboard'=>$row[2], 'content'=>Utils::replaceNewLine($row[3]), 'rdt'=>$row[4], 'reply'=>$row[5], 'nm'=>$row[6]));
}


echo json_encode(array("result"=>$result), JSON_UNESCAPED_UNICODE);
?>
