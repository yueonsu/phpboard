<?php
session_start();
$num = $_GET['num'];
$certification = $_SESSION['num'];

echo json_encode($num == $certification ? true : false);
?>