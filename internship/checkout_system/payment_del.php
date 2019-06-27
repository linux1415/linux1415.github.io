<?php
session_start();

$type = $_GET["type"];
$type = strtolower($type);

if ($type == 'cash') {
	unset($_SESSION['payment_array']['cash']);
}

if ($type == 'card') {
	unset($_SESSION['payment_array']['card']);
}

if (count($_SESSION['payment_array']) < 1) {
	unset($_SESSION['payment_array']);
}
echo '<script>window.location.href="pay.php";</script>';

?>