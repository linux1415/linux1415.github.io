<?php
session_start();
if (!isset($_SESSION['quizzer_id'])) {
	echo '<script>window.location.href="login.php";</script>';
	die();
}
?>