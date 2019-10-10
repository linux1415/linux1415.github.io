<?php
include 'verify.php';
include 'database_connect.php';
$user = $_SESSION['budget_id'];

$cat = mysqli_real_escape_string($conn, $_POST['category']);
$amount = mysqli_real_escape_string($conn, $_POST['amount']);

$cat = trim($cat);
$amount = trim($amount);

$update = "insert into categories (category_name, budget, user_id) values ('$cat', '$amount', '$user');";
mysqli_query($conn, $update);

echo "<script>window.location.href = 'edit_budget_categories.php';</script>";

?>