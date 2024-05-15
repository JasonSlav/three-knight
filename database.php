<?php

$host = 'localhost';
$user = 'root';
$pass = '';

$cnn = new mysqli($host, $user, $pass);

if ($cnn->connect_error) {
    die("Connection failed: " . $cnn->connect_error);
}

$sql1 = "SHOW DATABASES LIKE 'tkn';";
$q1 = $cnn->query($sql1);

if (mysqli_num_rows($q1) > 0) {
    $db = "tkn";
    $cnn = new mysqli($host, $user, $pass, $db);
    $sql2 = "SHOW TABLES LIKE 'user_account';";
    $q2 = $cnn->query($sql2);
    $sql4 = "SHOW TABLES LIKE 'barang';";
    $q4 = $cnn->query($sql4);
    $sql5 = "SHOW TABLES LIKE 'transaksi';";
    $q5 = $cnn->query($sql5);

    if (mysqli_num_rows($q2) > 0 && mysqli_num_rows($q4) > 0 && mysqli_num_rows($q5) > 0) {
        header("location: index.php");
        exit();
    }
}

if (isset($_GET['install'])) {
    $sql = "CREATE DATABASE tkn;";
    $q = $cnn->query($sql);
    if ($q) {
        $db = "tkn";
        $cnn = new mysqli($host, $user, $pass, $db);
        $sql3 = file_get_contents('web.sql');
        $q3 = $cnn->multi_query($sql3);
        echo "Database 'tkn' berhasil dibuat!";
    } else {
        die("Error membuat database " . $cnn->error);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalasi Database</title>
</head>

<body style="text-align: center;">
    <h1>Instalasi Database</h1>
    <p>Silahkan klik tombol dibawah ini untuk menginstal database</p>
    <br>
    <form action="" method="get"><input type="submit" name="install" value="Instal Database"></form>
    <br>
    <a href="index.php">Lanjut menuju Home</a>
</body>
<body style="text-align: center;">
</body>