<?php
session_start();
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
error_reporting(E_ALL ^ E_DEPRECATED);
$conn = new mysqli('localhost', 'root', 'kalijati123', 'my_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

?>
