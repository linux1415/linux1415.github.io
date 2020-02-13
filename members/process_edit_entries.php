<?php
include 'verify.php';
include 'database_connect.php';
$user = $_SESSION['budget_id'];

$id = $_POST['id'];
$entry = mysqli_real_escape_string($conn, $_POST['entry']);
$amount = mysqli_real_escape_string($conn, $_POST['amount']);
$date = $_POST['date'];

$entry = trim($entry);
$amount = trim($amount);

$update = "UPDATE entries SET entry_desc = '$entry', amount = '$amount', entry_date = '$date' WHERE entry_id = '$id' and user_id = '$user';";
mysqli_query($conn, $update);

echo "<script>window.location.href = 'edit_entries.php';</script>";

?>