<?php
session_start();
if (!isset($_SESSION['user_messenger']))
{
	echo "<script>window.location.replace('index.php');</script>";
    die();
}
$user = $_SESSION['user_messenger'];

session_regenerate_id();
?>

