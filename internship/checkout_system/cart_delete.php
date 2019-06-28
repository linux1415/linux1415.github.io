<?
session_start();
$sku= $_GET["sku"];
$invoice = $_GET["invoice"];
unset($_SESSION['sales_array']["$sku"]);
$_SESSION['invoice_num'] = $invoice;
echo '<script>window.location.href="new_sale_add.php";</script>';
?>
