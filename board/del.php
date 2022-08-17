<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/test/libs/Db.php';
use libs\Db;

session_start();
$iboard = $_GET['iboard'];
$iuser = $_SESSION['iuser'];

$result = Db::query("DELETE FROM board WHERE iboard = $iboard AND iuser = $iuser");
Db::query("DELETE FROM comment WHERE iboard = $iboard");

if($result) {
	header("Location:./main.php?page=1");
} else { ?>
	<script>
		alert('삭제 실패');
	</script>
<?php 
} ?>