<?php
require_once('connection.php');
session_start(); // start the session

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  die('Method Not Allowed');
}

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE Email='$email' AND Password='$password'";
$result = $conn->query($sql);

if ($result->num_rows === 1) {
  $user = $result->fetch_assoc();
  $_SESSION['token'] = $user['user_id'];
  http_response_code(200);
  echo json_encode(array('success' => 'Successfully logged in', 'user' => $user));
} else {
  http_response_code(401);
  echo json_encode(array('error' => 'Invalid credentials'));
}

$conn->close();
?>
