<?php
session_start();
include 'verify.php';
if (!isset($_SESSION['user']))
{
    die(include 'index.html');
}
include 'database_connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Database Connect</title>
<meta charset="utf-8">
<style type="text/css" media="screen">
	
body {
	font-family: sans-serif;
	margin-left: 2em;
	width: 1000px;
	height: 700px;
	border: 1px solid black;
	box-shadow: 5px 5px 0 0;
	margin-left: auto;
	margin-right: auto;
}

#logout {
	margin-left: 335px;
}

#user {
	margin-left: 335px;
}

img {
	margin-right: 335px;
	float: right;
	margin-left: 200px;
}

input[type=submit] {
	font-size:22pt;
	height:40px;
	width:330px;
	margin-bottom:10px;
}

* {box-sizing:border-box}

/* Slideshow container */
.slideshow-container {
  max-width: 1000px;
  position: relative;
  margin: auto;
}

/* Hide the images by default */
.mySlides {
  display: none;
}

/* Next & previous buttons */
.prev, .next {
  cursor: pointer;
  position: absolute;
  top: 50%;
  width: auto;
  margin-top: -22px;
  padding: 16px;
  color: black;
  font-weight: bold;
  font-size: 18px;
  transition: 0.6s ease;
  border-radius: 0 3px 3px 0;
  user-select: none;
}

/* Position the "next button" to the right */
.next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover, .next:hover {
  background-color: rgba(0,0,0,0.8);
}

/* Caption text */
.text {
  color: black;
  font-size: 15px;
  padding: 8px 12px;
  position: absolute;
  bottom: 8px;
  width: 100%;
  text-align: center;
}

/* Number text (1/3 etc) */
.numbertext {
  color: black;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
  float: left;
}

/* The dots/bullets/indicators */
.dot {
  cursor: pointer;
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: black;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease;
}

.active, .dot:hover {
  background-color: black;
}

/* Fading animation */
.fade {
  -webkit-animation-name: fade;
  -webkit-animation-duration: 1.5s;
  animation-name: fade;
  animation-duration: 1.5s;
}

@-webkit-keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}

@keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}
	
</style>
</head>
<main>
<body>
<img src="logo.png" alt="logo" style="width:330px;height:255px;">
<div id="centered">
<div class="slideshow-container">
<?php
$user = $_SESSION['user'];
$logout = "";
$page1 = ""; $page2 = ""; $page3 = ""; $page4 = ""; $page5 = "";
$query = "select * from permissions where user_id='$user';";

$query2 = "select * from permissions_tables where user_id='$user';";

$array = mysqli_query($conn, $query);
$perm1 = mysqli_fetch_array($array, MYSQLI_ASSOC);

$array2 = mysqli_query($conn, $query2);
$perm2 = mysqli_fetch_array($array2, MYSQLI_ASSOC);

if (count($perm1) < 1 || count($perm2) < 1) {
	echo '<script>window.location.href="index.html";</script>';
	die();
}


function check_count($num) {
	global $page1; global $page2; global $page3; global $page4; global $page5;
	if ($num == 5) {
		if ($page1 != 'yes') {
			echo "</div>";
			echo "</div>";
			echo  "<div class='mySlides fade'>";
			echo '<div style="width:100%; height: 600px; text-align: center;">';
			$page1 = 'yes';
		}
	}
	if ($num == 10) {
		if ($page2 != 'yes') {
			echo "</div>";
			echo "</div>";
			echo  "<div class='mySlides fade'>";
			echo '<div style="width:100%; height: 600px; text-align: center;">';
			$page2 = 'yes';
		}
	}
	if ($num == 15) {
		if ($page3 != 'yes') {
			echo "</div>";
			echo "</div>";
			echo  "<div class='mySlides fade'>";
			echo '<div style="width:100%; height: 600px; text-align: center;">';
			$page3 = 'yes';
		}
	}
	if ($num == 20) {
		if ($page4 != 'yes') {
			echo "</div>";
			echo "</div>";
			echo  "<div class='mySlides fade'>";
			echo '<div style="width:100%; height: 600px; text-align: center;">';
			$page4 = 'yes';
		}
	}
	if ($num == 25) {
		if ($page5 != 'yes') {
			echo "</div>";
			echo "</div>";
			echo  "<div class='mySlides fade'>";
			echo '<div style="width:100%; height: 600px; text-align: center;">';
			$page5 = 'yes';
		}
	}
}

function check_logout($num) {
	global $logout; global $count;
	if ($num == 4) {
		if ($logout != 'yes') {
			echo "<form action='logout.php'>
			<input type='submit' value='Logout'/>
			</form>";
			$count += 1;
			$logout = 'yes';
		}
	}
}

echo  "<div class='mySlides fade'>";
echo '<div style="width:100%; height: 600px; text-align: center;">';
$count = 0;

if ($perm1['add_sale'] != 'no') {
	echo "<form action='sales/new_sale_add.php'>";
    echo "<input type='submit' value='Cart'/>
	</form>";
	$count += 1;
}

echo "<form action='sales/orders_table.php'>";
echo "<input type='submit' value='Orders'/>
	</form>";
$count += 1;


if ($perm1['edit_sale'] != 'no') {
	if ($perm1['edit_sale'] == 'full_access') {
		echo "<form action='sales/edit_delete_sales.php'>";
	}
	else {
		echo "<form action='sales/edit_level_1.php'>";
	}
    echo "<input type='submit' value='Edit Sale'/>
	</form>";
	$count += 1;
}

if ($perm1['add_commission'] != 'no') {
	echo "<form action='sales/commission_add.php'>
    <input type='submit' value='Add Commission'/>
	</form>";
	$count += 1;
}

check_logout($count);

check_count($count);

if ($perm1['add_inventory'] != 'no') {
	if ($perm1['add_inventory'] == 'full_access') {
		echo "<form action='inventory/inventory_add.php.php'>";
	}
	else {
		echo "<form action='inventory/inventory_add_limited.php'>";
	}
    echo "<input type='submit' value='Add Inventory'/>
	</form>";
	$count += 1;
}

check_logout($count);

check_count($count);

if ($perm1['edit_inventory'] != 'no') {
	echo "<form action='inventory/inventory_edit.php'>
    <input type='submit' value='Edit Inventory'/>
	</form>";
	$count += 1;
}

check_logout($count);

check_count($count);

if ($perm1['add_product'] != 'no') {
	echo "<form action='products/products_add.php'>
    <input type='submit' value='Add Product'/>
	</form>";
	$count += 1;
}

check_logout($count);

check_count($count);

if ($perm1['edit_product'] != 'no') {
	echo "<form action='products/products_edit.php'>
    <input type='submit' value='Edit Products'/>
	</form>";
	$count += 1;
}

check_logout($count);

check_count($count);

if ($perm1['add_repair_option'] != 'no') {
	echo "<form action='repairs/repair_info_add.php'>
    <input type='submit' value='Add Repair Option'/>
	</form>";
	$count += 1;
}

check_logout($count);

check_count($count);

if ($perm2['sales_performance'] != 'no') { //10
	if ($perm2['sales_performance'] == 'full_access' || $perm2['sales_performance'] == 'store_access') {
		echo "<form action='sales_performance/performance_filter_level_2.php'>";
	}
	else {
		echo "<form action='sales_performance/performance_level_1.php'>";
	}
    echo "<input type='submit' value='Sales Performance'/>
	</form>";
	$count += 1;
}

check_logout($count);

check_count($count);

if ($perm2['item_performance'] != 'no') {
	echo "<form action='sales_performance/item_performance_filter.php'>
    <input type='submit' value='Item Performance'/>
	</form>";
	$count += 1;
}

check_logout($count);

check_count($count);

if ($perm2['category_performance'] != 'no') {
	echo "<form action='sales_performance/category_performance_filter.php'>
    <input type='submit' value='Category Performance'/>
	</form>";
	$count += 1;
}

check_logout($count);

check_count($count);

if ($perm2['inventory'] != 'no') {
	echo "<form action='inventory/inventory_table.php'>
    <input type='submit' value='Inventory'/>
	</form>";
	$count += 1;
}

check_logout($count);

check_count($count);

if ($perm2['products'] != 'no') {
	echo "<form action='products/products_table.php'>
    <input type='submit' value='Products'/>
	</form>";
	$count += 1;
}

check_logout($count);

check_count($count);

if ($perm2['repairs'] != 'no') {
	echo "<form action='repairs/repairs_table.php'>
    <input type='submit' value='Repairs'/>
	</form>";
	$count += 1;
}

check_logout($count);

check_count($count);

echo "<form action='other/request_send.php'>
    <input type='submit' value='Submit Request'/>
	</form>";
	
check_logout($count);

if ($count < 4) {
	echo "<form action='logout.php'>
    <input type='submit' value='Logout'/>
	</form>";
}
?>
</div>
</div>
<?php
if ($count > 5) {
	echo '<a class="prev" onclick="plusSlides(-1)">&#10094;</a>';
	echo '<a class="next" onclick="plusSlides(1)">&#10095;</a>';
}
?>
</div>
<div style="text-align:center">
<?php
if ($count > 5) {	
	echo '<span class="dot" onclick="currentSlide(1)"></span>';
	echo '<span class="dot" onclick="currentSlide(2)"></span>';
}

if ($count > 10) {	
	echo '<span class="dot" onclick="currentSlide(3)"></span>';
}

if ($count > 15) {	
	echo '<span class="dot" onclick="currentSlide(4)"></span>';
}

if ($count > 20) {	
	echo '<span class="dot" onclick="currentSlide(5)"></span>';
}
?> 
</div>
<?php
$name = $_SESSION['name'];
echo "<div id='user'><h2 style='width:330px;text-align:center;';>" . $name . "</h2></div>";
?>
</body>
<script>
var slideIndex = 1;
showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
  showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1} 
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none"; 
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block"; 
  dots[slideIndex-1].className += " active";
}

</script>
</main>
</html>
<?php
include 'alerted.php';
?>