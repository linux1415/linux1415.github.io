<?php
include 'verify.php';
include 'database_connect.php';
$user = $_SESSION['budget_id'];

$id = $_POST['id'];
$cat = mysqli_real_escape_string($conn, $_POST['category']);
$amount = mysqli_real_escape_string($conn, $_POST['amount']);

$cat = trim($cat);
$amount = trim($amount);

$update = "UPDATE categories SET category_name = '$cat', budget = '$amount' WHERE category_id = '$id' and user_id = '$user';";
mysqli_query($conn, $update);

echo "<script>window.location.href = 'edit_budget_categories.php';</script>";

?>