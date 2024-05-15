<?php

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'tkn';

$error = '';

$cnn = mysqli_connect($host, $user, $pass, $db);

if (!$cnn) {
  header("location: database.php");
}
?>