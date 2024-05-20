<?php

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'tkn';

$error = '';

$cnn = new mysqli($host, $user, $pass, $db);

if (!$cnn) {
  header("location: database.php");
  exit();
}
?>