<?php
session_start();
if (!isset($_SESSION['id_app_tracker'])) {
	echo '<script>window.location.href="login.php";</script>';
	die();
}
?>