<?php
session_start();
if (!isset($_SESSION['message']) & !isset($_SESSION['allow']))
{
	echo "<script>window.location.replace('../index.html');</script>";
    die();
}

session_regenerate_id();
?>