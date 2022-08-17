<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/test/libs/Db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/test/libs/Utils.php';
use libs\Utils;
use libs\Db;

session_start();

$iboard = $_POST['iboard'];
// $title = Utils::preventScript($_POST['title']);
$title = Utils::write($_POST['title']);
$content = Utils::write($_POST['content']);
$iuser = $_SESSION['iuser'];
$movePage = "";

$sql = "";
if($iboard > 0) {
	$sql = "UPDATE board SET title = '$title', content = '$content' WHERE iboard = $iboard";
    $result = Db::query($sql);
} else {
	$sql = "insert into board (title, content, iuser) values ('$title', '$content', '$iuser')";
    $result = Db::query($sql);
    $iboard = mysqli_fetch_assoc(Db::query("SELECT iboard FROM board WHERE iuser = $iuser ORDER BY rdt desc LIMIT 1"))['iboard'];
}



header("Location:/test/board/detail.php?iboard=" . $iboard);



?>