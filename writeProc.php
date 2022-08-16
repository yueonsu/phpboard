<?php
require_once 'libs/Db.php';
require_once 'libs/Utils.php';
use libs\Utils;
use libs\Db;

session_start();

$iboard = $_POST['iboard'];
// $title = Utils::preventScript($_POST['title']);
$title = $_POST['title'];
$content = Utils::preventScript($_POST['content']);
$iuser = $_SESSION['iuser'];

$sql = "";
if($iboard != NULL || $iboard > 0) {
	$sql = "UPDATE board SET title = '$title', content = '$content' WHERE iboard = $iboard";
} else {
	$sql = "insert into board (title, content, iuser) values ('$title', '$content', '$iuser')";
}

if(mb_strlen($title) < 100 && mb_strlen($content) < 3000) {
	$result = Db::query($sql);
}



if($result) {
	$result = mysqli_fetch_assoc(Db::query("select iboard from board where iuser = $iuser order by iboard desc limit 1"))['iboard'];
	?>
	<script>
		location.replace('./detail.php?iboard=<?php echo $result;?>');
	</script>
<?php
} else {
    header("Location:./main.php?page=1&error=write");
}
 ?>