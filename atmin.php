<?php include("connect.php"); ?>
<?php session_start() ?>
<?php

$id = '';
$stok = '';
$error = '';

$sql1 = "SELECT * FROM barang WHERE id_barang = '$id'";
$q1 = mysqli_query($cnn, $sql1);

if (mysqli_num_rows($q1) > 0) {
    while ($r1 = mysqli_fetch_array($q1)) {
        $id = $r1['id'];
        $stok = $r1['stok'];
    }
} else {
    $error = "Barang tidak ditemukan";
}

if (!isset($_SESSION['username'])) {
    header("location: admin.php");
} else {
    echo "Welcome, " . $_SESSION['username'] . "!";
    if (isset($_POST['edit'])) {
        $id = $_POST['id'];
        $stok = $_POST['stok'];

        if ($stok < 0) {
            $error = "Stok tidak boleh negatif";
        } else {
            $sql2 = "UPDATE barang SET stok = '$stok' WHERE id_barang = '$id'";
            $q2 = mysqli_query($cnn, $sql2);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN ONLY</title>
</head>

<body>
    <h1>Stok Barang</h1>
    <?php
    $sql3 = "SELECT nama_barang, stok FROM barang ORDER BY id_barang";
    $q3 = mysqli_query($cnn, $sql3);
    while ($r2 = mysqli_fetch_array($q3)) {
        echo "<p style='display: inline; text-decoration: underline'>" . $r2['nama_barang'] . "</p><br>";
        echo "<p style='display: inline'> Stok: " . $r2['stok'] . "</p><br>";
    }
    echo "<br>";
    ?>
    <form action="" method="post">
        <input type="text" name="id" placeholder="ID">
        <input type="text" name="stok" placeholder="Stok"><br><br>
        <input type="submit" name="edit" value="Update">
    </form>
    <p><a href="logoutadmin.php">Logout</a></p>
    <script>
        window.location.href = window.location.href
    </script>
</body>

</html>