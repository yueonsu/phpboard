<?php
session_start();
$num = $_GET['num'];
$certification = $_SESSION['num'];
$result = false;
if($certification == $_SESSION['num']) {
    unset($_SESSION['num']);
    $result = true;
}
echo json_encode($result);
?>