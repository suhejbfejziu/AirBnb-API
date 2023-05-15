<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header('Access-Control-Allow-Headers: Content-Type');
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "airbnb";

$conn = new mysqli($servername, $username, $password, $dbname);

?>