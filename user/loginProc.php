<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/test/libs/Crypt.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/test/libs/Db.php';
use libs\Crypt;
use libs\Db;

$crypt = new Crypt();

$id = $_POST['id'];
$pw = $_POST['pw'];
$prevUrl = $_POST['prevUrl'];;

if(mb_strlen($id) == 0 || mb_strlen($pw) == 0) {
    header("Location:./login.php?error=2");
    return;
}

$result = Db::query("select * from user where id = '$id'");

if($result) {
	$row = mysqli_fetch_assoc($result);

	if($pw == $crypt->Decrypt($row['pw'], "123456789", "#@$%^&*()_+=-")) {

		session_start();
		$_SESSION['iuser'] = $row['iuser'];

?>
		<script>
			location.replace('<?php echo $prevUrl;?>');
		</script>

<?php 	} else { ?>
		<script>
			location.replace('./login.php?error=1');
		</script>
<?php 	}
	}
?>
