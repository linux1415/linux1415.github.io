<?php
include 'verify.php';
include 'database_connect.php';
$user = $_SESSION['budget_id'];

$id = $_POST['id'];

$update = "delete from entries WHERE entry_id = '$id' and user_id = '$user';";
mysqli_query($conn, $update);

echo "<script>window.location.href = 'edit_entries.php';</script>";

?>