<?php
session_start();
if (!isset($_SESSION['budget_id'])) {
	echo '<script>window.location.href="login.php";</script>';
	die();
}
?>