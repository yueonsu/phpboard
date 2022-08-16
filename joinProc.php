<?php
require_once 'libs/Crypt.php';
require_once 'libs/Db.php';
use libs\Crypt;
use libs\Db;



$id = $_POST['id'];
$pw = $_POST['pw'];
$nm = $_POST['nm'];
$email = $_POST['email'];

$crypt = new Crypt();
$pw = $crypt->Encrypt($pw, "123456789", "#@$%^&*()_+=-");

$result = Db::query("insert into user (id, pw, nm, email) values ('$id', '$pw', '$nm', '$email')");

if($result) {
	?>
<script>
location.replace('./main.php');
</script>
<?php 
} else {?>
<script>
location.replace('./join.php');
</script>
<?php 
} ?>
<?php 

mysqli_close($con);

?>
