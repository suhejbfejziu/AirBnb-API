<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header('Access-Control-Allow-Headers: Content-Type');
session_start();

// Unset all session variables
session_unset();

// destroy the session
session_destroy();
exit;
?>
