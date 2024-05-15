<?php
include("connect.php");
session_start();
?>
<?php
if (!isset($_SESSION['username'])) {
    header("location: logres.php");
    exit();
}
?>
<?php
$id = "";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header("location: index.php");
    exit();
}
?>
<?php
$jumlah = "";
$error = "";
$success = "";
$email = $_SESSION['email'];

if (isset($_POST['buy'])) {
    $jumlah = $_POST['quantity'];
    if ($jumlah == "") {
        $error = "Jumlah harus diisi";
    }

    $sql_check1 = "SELECT * FROM barang WHERE id_barang = '$id'";
    $q_check1 = mysqli_query($cnn, $sql_check1);
    $r_check1 = mysqli_fetch_array($q_check1);
    $stok = $r_check1['stok'];
    if ($stok < $jumlah) {
        $error = "Stok tidak mencukupi";
    }

    if (empty($error)) {
        $sql_check = "SELECT * FROM cart WHERE email = '$email' AND id_barang = '$id'";
        $q_check = mysqli_query($cnn, $sql_check);
        if (mysqli_num_rows($q_check) > 0) {
            $r_check = mysqli_fetch_array($q_check);
            $jumlah_awal = $r_check['jumlah'];
            $jumlah = $jumlah + $jumlah_awal;

            if ($stok < $jumlah) {
                $error = "Anda telah menambahkan barang ini di keranjang. jumlah total beli anda melebihi stok";
            } else {
                $sql_update = "UPDATE cart SET jumlah = '$jumlah' WHERE email = '$email' AND id_barang = '$id'";
                $q_update = mysqli_query($cnn, $sql_update);
                if ($q_update) {
                    $success = "Jumlah ditambahkan";
                } else {
                    $error = "Jumlah gagal ditambahkan";
                }
            }
        } else {
            $sql_insert = "INSERT INTO cart (email, id_barang, jumlah) VALUES ('$email', '$id', '$jumlah')";
            $q_insert = mysqli_query($cnn, $sql_insert);
            if ($q_insert) {
                $success = "Jumlah ditambahkan";
            } else {
                $error = "Jumlah gagal ditambahkan";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="cart.css">
</head>

<body>
    <div class="cart-buy">
        <?php
        $sql_cloth = "SELECT * FROM `barang` WHERE `id_barang` = '$id'";
        $q_cloth = mysqli_query($cnn, $sql_cloth);
        $r_cloth = mysqli_fetch_array($q_cloth);
        ?>
        <h1> Buy Now </h1>
        <h3 class="shirt"> <?php echo $r_cloth['nama_barang'] ?></h3>
        <?php if ($error) {
            echo "<h5> $error </h5>";
        } ?>
        <?php if ($success) {
            echo "<h5> $success </h5>";
        } ?>
        <img src="images/<?php echo $r_cloth['foto'] ?>" alt="shirt" style="margin: -50px 0 -50px 0">
        <p class="stok"> Stok: <?php echo $r_cloth['stok'] ?></p>
        <form action="" method="POST">
            <label for="quantity"> Quantity: </label>
            <input type="number" name="quantity" placeholder="1" />
            <input style="cursor: pointer;" class="button" type="submit" name="buy" value="Add to cart" />
        </form>
        <a href="index.php" class="home"> Back to Home </a>
        <footer style="background-color: #121212; padding: 0.7em; bottom: 0; left: 0; position: fixed">
            <h2 style="color:white; text-align:center; margin: -5px; padding-right: auto; font-size: 16px">threeknight.store</h2>
        </footer>
    </div>
</body>

</html>