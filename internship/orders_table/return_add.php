<?php
session_start();

$item = $_GET["item"];
$id = $_GET["id"];
$type = $_GET["type"];
$price = $_GET["price"];

	
if (!isset($_SESSION['return_array']))
{
    $_SESSION['return_array'] = array();
}

$_SESSION['return_array']["$id"] = array($item, $price, $type);


//$_SESSION['return_array']["$id"] = $item;



echo '<script>window.location.href="returns.php";</script>';


?>