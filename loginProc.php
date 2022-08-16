<?php
require_once 'libs/Crypt.php';
require_once 'libs/Db.php';
use libs\Crypt;
use libs\Db;

$crypt = new Crypt();

$id = $_POST['id'];
$pw = $_POST['pw'];
$prevUrl = $_POST['prevUrl'];;
$result = Db::query("select * from user where id = '$id'");

if($result) {
	$row = mysqli_fetch_assoc($result); // return type : object
	
	if($pw == $crypt->Decrypt($row['pw'], "123456789", "#@$%^&*()_+=-")) {
		
		session_start();
		$_SESSION['iuser'] = $row['iuser'];
		
?>
		<script>
			location.replace('<?php echo $prevUrl;?>');
		</script>
		
<?php 	} else { ?>
		<script>
			location.replace('./login.php');
		</script>
<?php 	} 
	} else {	
?>

	<script>
		location.replace('./login.php');	
	</script>
<?php 
	}
?>