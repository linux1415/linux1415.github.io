<?php
include 'verify.php';
include 'database_connect.php';
$user = $_SESSION['budget_id'];


$id = $_POST['id'];
$desc = mysqli_real_escape_string($conn, $_POST['desc']);
$amount = mysqli_real_escape_string($conn, $_POST['amount']);
$date = $_POST['date'];

$desc = trim($desc);
$amount = trim($amount);

if ($desc != "" && $amount != "") {
	$update = "insert into entries (entry_desc, amount, category_id, entry_date, user_id) values ('$desc', '$amount', '$id', '$date', '$user');";
	mysqli_query($conn, $update);
}

echo "<script>window.location.href = 'home.php';</script>";

?>