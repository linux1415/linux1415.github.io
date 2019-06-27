<?php
include 'authenticate.php';

ini_set('display_errors', 'Off');

include 'db_connect.php';

$date = $_GET["v"];

$delete = "DELETE FROM messages WHERE date='$date';";

mysqli_query($conn, $delete);

$_SESSION['d'] = 'delete';

die(include 'decrypt.php');


?>