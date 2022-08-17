<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . '/test/libs/Db.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/test/libs/Crypt.php';
use libs\Db;
use libs\Crypt;

session_start();
$c = new Crypt();

$decoded = json_decode(file_get_contents("php://input"));

$iuser = $_SESSION['iuser'];
$pw = $decoded->pw;
$encodedPw = mysqli_fetch_assoc(Db::query("SELECT * FROM user WHERE iuser = $iuser"))['pw'];

if($pw == $c->Decrypt($encodedPw, "123456789", "#@$%^&*()_+=-")) {
	echo json_encode(true);
} else {
	echo json_encode(false);
}

?>