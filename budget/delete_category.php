<?php
include 'verify.php';
include 'database_connect.php';
$user = $_SESSION['budget_id'];

$id = $_POST['id'];

$update = "delete from categories WHERE category_id = '$id' and user_id = '$user';";
mysqli_query($conn, $update);

$update2 = "delete from entries WHERE category_id = '$id' and user_id = '$user';";
mysqli_query($conn, $update2);

echo "<script>window.location.href = 'edit_budget_categories.php';</script>";

?>