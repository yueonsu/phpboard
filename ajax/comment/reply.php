<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/test/libs/Db.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/test/libs/Utils.php';
use libs\Utils;
use libs\Db;
session_start();

$decoded = json_decode(file_get_contents("php://input"));

$content = $decoded->content;
$reply = $decoded->reply;
$iuser = $_SESSION['iuser'];
$iboard = $decoded->iboard;
$icmt = $decoded->icmt;
$secret = $decoded->secret;

$result = "";
if(!$icmt) {
	$result = Db::query("INSERT INTO comment (iuser, content, reply, iboard) VALUES ($iuser, '$content', $reply, $iboard)");
} else {
	$result = Db::query("UPDATE comment SET content = '$content', secret = $secret WHERE icmt = $icmt AND iuser = $iuser");
}

$array = array();
$row = mysqli_fetch_assoc(Db::query("SELECT A.*, B.nm FROM comment A INNER JOIN user B ON A.iuser = B.iuser WHERE A.content = '$content'"));

array_push($array, array('result'=>$result, 'content'=>Utils::replaceNewLine($row['content']), 'nm'=>$row['nm'], 'rdt'=>$row['rdt'], 'icmt'=>$row['icmt'], 'iuser'=>$row['iuser'], 'secret'=>$row['secret']));


echo json_encode($array);
?>