<?php
session_start();

$id = $_GET["id"];

unset($_SESSION['return_array']["$id"]);

if (count($_SESSION['return_array']) < 1) {
	unset($_SESSION['return_array']);
}
echo '<script>window.location.href="returns.php";</script>';

?>