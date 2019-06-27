<?php
session_start();

ini_set('display_errors', 'Off');

$password = "";
$servername = "";
$username = "";
$dbname = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

?>