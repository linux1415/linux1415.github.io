<?php
session_start();

$_SESSION['budget_id'] = '1';
echo '<script>window.location.href="home.php";</script>';

die();

?>