<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/test/libs/Db.php';
use libs\Db;

$icmt = $_GET['icmt'];
$array = Db::query("SELECT A.*, B.nm FROM comment A INNER JOIN user B ON A.iuser = B.iuser WHERE reply = $icmt ORDER BY A.rdt");

$result = array();
while($row = mysqli_fetch_array($array)) {
	array_push($result, array('icmt'=>$row[0], 'iuser'=>$row[1], 'iboard'=>$row[2], 'content'=>$row[3], 'rdt'=>$row[4], 'reply'=>$row[5], 'nm'=>$row[6]));
}

echo json_encode(array("result"=>$result));
?>