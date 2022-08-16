<?php
require_once 'libs/Db.php';
use libs\Db;

$iboard = $_GET['iboard'];
$iuser = $_GET['iuser'];

$like = mysqli_fetch_assoc(Db::query("SELECT COUNT(*) AS `like` FROM `like` WHERE iboard = $iboard AND iuser = $iuser"))['like'];
if($like == 0) {
	Db::query("INSERT INTO `like` (iboard, iuser) VALUES ($iboard, $iuser)");
	echo 1;
} else if ($like == 1) {
	Db::query("DELETE FROM `like` WHERE iboard = $iboard AND iuser = $iuser");
	echo 0;
}

?>