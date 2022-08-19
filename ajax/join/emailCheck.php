<?php
session_start();
$num = $_GET['num'];
$certification = $_SESSION['num'];
$result = false;
if($certification == $num) {
    unset($_SESSION['num']);
    $result = true;
}
echo json_encode($result);
?>