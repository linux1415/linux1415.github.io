<?php
session_start();

$type = $_GET["type"];
$type = strtolower($type);

if ($type == 'cash') {
	unset($_SESSION['refund_array']['cash']);
}

if ($type == 'card') {
	unset($_SESSION['refund_array']['card']);
}

if (count($_SESSION['refund_array']) < 1) {
	unset($_SESSION['refund_array']);
}
echo '<script>window.location.href="refunds.php";</script>';

?>