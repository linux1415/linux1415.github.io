<?php
session_start();
include '../verify.php';

if (!isset($_SESSION['user']))
{
    die(include 'index.php');
}
include '../database_connect.php';

$invoice = $_GET['num'];
$cust = $_GET['cust'];

if ($cust != '0') {
$query = "select id_num, first_name, last_name, phone, city, zip from customers
	where id_num='$cust';";
$array = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($array, MYSQLI_ASSOC)){ 
	$f_name = $row['first_name'];
	$l_name = $row['last_name'];
	$phone = $row['phone_num'];
	$city = $row['city'];
	$zip = $row['zip'];
	$id = $row['id_num'];
	}
} 	
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <link rel="stylesheet" href="style.css" media="all" />
  </head>
  <body>
    <header class="clearfix">
	  <div id="logo">
        <img src="logo.png">
      </div>
      <div id="company" class="clearfix">
        <div>Hashtag iFix iT</div>
        <div>2243 Lowes Dr<br>Clarksville, TN 37040</div>
        <div>(931)802-7137</div>
        <div><a href="mailto:company@example.com">hashtag@example.com</a></div>
      </div>
      <div id="project">
        <div><span>BILL TO</span><? echo"$f_name" . " " . "$l_name"?></div>
		<div><span>ID</span><?echo"$id";?></div>
        <div><span>ZIP</span><?echo"$zip";?></div>
        <div><span>CITY</span><?echo"$city";?></div>
        <div><span>EMAIL</span> <a href="mailto:john@example.com">jimmy@example.com</a></div>
        <div><span>DATE</span> August 17, 2015</div>
      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr>
            <th class="service">SKU</th>
            <th class="desc">DESCRIPTION</th>
            <th class="unit">PRICE</th>
            <th class="qty">QTY</th>
            <th class="total">TOTAL</th>
          </tr>
        </thead>
        <tbody>
		<?
	$query = "SELECT item, sku, item_price, count(sku) as qty, sum(item_price) as total 
	from sales where invoice_num='$invoice' group by item, sku, item_price;";
	$array = mysqli_query($conn, $query);
	$total = 0;
	while ($row = mysqli_fetch_array($array, MYSQLI_ASSOC)){ 
		$item = $row['item'];
		$sku = $row['sku'];
		$price = $row['item_price'];
		$qty = $row['qty'];
		$item_total = $row['total'];
		echo "<tr>";
		echo "<td class='service'>$sku</td><td class='desc'>$item</td><td class='unit'>$$price</td><td class='qty'>$qty</td><td class='total'>$$item_total</td>";
		echo "</tr>";
		$total += $item_total;
	}
	
	$query = "SELECT description, sku, cost, count(sku) as qty, sum(cost) as total 
	from repair_sales where invoice_num='$invoice' group by description, sku, cost;";
	$array = mysqli_query($conn, $query);
	while ($row = mysqli_fetch_array($array, MYSQLI_ASSOC)){ 
		$item = $row['description'];
		$sku = $row['sku'];
		$price = $row['cost'];
		$qty = $row['qty'];
		$item_total = $row['total'];
		echo "<tr>";
		echo "<td class='service'>$sku</td><td class='desc'>$item</td><td class='unit'>$$price</td><td class='qty'>$qty</td><td class='total'>$$item_total</td>";
		echo "</tr>";
		$total += $item_total;
	}
	$tax = round($total * .09, 2);
	$total2 = round($total + ($total * .09), 2);
	
	$query = "SELECT total, balance, amount_payed
	from invoices where invoice_num='$invoice';";
	$array = mysqli_query($conn, $query);
	$row = mysqli_fetch_array($array, MYSQLI_ASSOC);
	
	$payed = $row['amount_payed'];
	$balance = $row['balance'];
	?>
          <tr>
            <td colspan="4">SUBTOTAL</td>
            <td class="total">$<?echo "$total";?></td>
          </tr>
          <tr>
            <td colspan="4">TAX 9%</td>
            <td class="total">$<?echo "$tax";?></td>
          </tr>
          <tr>
            <td colspan="4" class="grand total">GRAND TOTAL</td>
            <td class="grand total">$<?echo "$total2";?></td>
          </tr>
		  <tr>
            <td colspan="4" class="grand total">AMOUNT PAID</td>
            <td class="grand total">$<?echo "$payed";?></td>
          </tr>
		  <tr>
            <td colspan="4" class="grand total">BALANCE</td>
            <td class="grand total">$<?echo "$balance";?></td>
          </tr>
        </tbody>
      </table>
      <div id="notices">
        <div>Return Policy:</div>
        <div class="notice">The return policy</div>
      </div>
    </main>
  </body>
</html>