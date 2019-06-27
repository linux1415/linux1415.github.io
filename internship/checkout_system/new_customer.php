<?php
session_start();
include '../database_connect.php'; 

$l_name = $_GET["l_name"];
$f_name = $_GET["f_name"];
$n_phone = $_GET["n_phone"];
$city = $_GET["city"];
$zip = $_GET["zip"];


$query = "insert into customers (first_name, last_name, phone, city, zip) values ('$f_name', '$l_name', '$n_phone', '$city', '$zip');";


if ($conn->query($query) === TRUE) {
	echo "<script>";
	echo "alert('New Customer Added.');";
	echo "</script>";
	}
else {
	echo "<script>";
	echo "alert('Error. Try again later.');";
	echo "</script>";
	}

echo "<script>window.location.href=\"choose_customer.php?phone=$n_phone\";</script>";


?>

