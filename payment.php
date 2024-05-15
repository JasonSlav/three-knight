<?php include("connect.php") ?>
<?php session_start();

$nama = '';
$alamat = '';
$error = '';
$success = '';

if (isset($_SESSION['username'])) {
    $email = $_SESSION['email'];
    $sql3 = "SELECT * FROM user_account WHERE email = '$email'";
    $q3 = mysqli_query($cnn, $sql3);
    $r = mysqli_fetch_array($q3);
}

if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];

    if ($nama == '' or $alamat == '') {
        $error = "All fields are required";
    }

    if (empty($error)) {
        $email1 = $r['email'];
        $sql4 = "SELECT * FROM cart WHERE email = '$email1'";
        $q4 = mysqli_query($cnn, $sql4);
        while ($r2 = mysqli_fetch_array($q4)) {
            $sql5 = "INSERT INTO transaksi (email, id_barang, jumlah) VALUES ('$email1', '$r2[id_barang]', '$r2[jumlah]');";
            $q5 = mysqli_query($cnn, $sql5);
            if ($q5) {
                $sql6 = "UPDATE transaksi SET nama = '$nama', alamat = '$alamat'
                                    WHERE email = '$email1';";
                $q6 = mysqli_query($cnn, $sql6);
                if ($q6) {
                    $sql7 = "UPDATE barang SET stok = stok - $r2[jumlah] WHERE id_barang = '$r2[id_barang]';";
                    $q7 = mysqli_query($cnn, $sql7);
                    $sql8 = "DELETE FROM cart WHERE id_cart = '$r2[id_cart]';";
                    $q8 = mysqli_query($cnn, $sql8);
                    $success = "Transaction successful, please proceed into WhatsApp for confirmation below";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="payment.css">
</head>

<body>
    <header style="position: fixed; left: 1em; right: 1em;">
        <h2 style="margin-top: 0; float: left">Checkout</h2>
        <p style="margin-top: 0; float: right;">hello, <?php echo $_SESSION['username']; ?>!</p>
    </header>
    <header style="color: rgba(255, 255, 255, 0); height: 2em"></header>
    <div class="row">
        <div class="container">
            <form method="post" action="">
                <div class="row-2">
                    <div class="col-50">
                        <?php
                        if (isset($_SESSION['username'])) {
                            $email = $_SESSION['email'];
                            $sql1 = "SELECT * FROM cart WHERE email = '$email'";
                            $q1 = mysqli_query($cnn, $sql1);
                            $total = 0;
                            while ($r1 = mysqli_fetch_array($q1)) {
                                $id = $r1['id_barang'];
                                $sql2 = "SELECT * FROM barang WHERE id_barang = '$id'";
                                $q2 = mysqli_query($cnn, $sql2);
                                $r2 = mysqli_fetch_array($q2);
                                echo "<br>";
                                echo "<span style='float: left;'>" . $r2['nama_barang'] . ": </span> <span style='float: right;'> IDR " . $r2['harga'] . " x " . $r1['jumlah'] . " </span>";
                                echo "<br>";
                                $harga = $r2['harga'] * $r1['jumlah'];
                                $total += $harga;
                            }
                        } else {
                            header("location: index.php");
                            exit;
                        }
                        ?>
                        <hr>
                        <br>
                        <span>Total: <?php echo "<span style='float: right'>IDR " . $total . "</span>"; ?></span>
                        <h3 style="text-align: center; margin: 1em 0 0 1em">Please Enter Your Information</h3>
                        <?php if ($error) {
                            echo "<p style='color: red'>" . $error . "</p>";
                        } else {
                            echo "<p style='text-align: center'>" . $success . "</p>";
                        } ?>
                        <label for="nama"><i class="fa fa-user"></i> Full Name</label>
                        <input type="text" id="nama" name="nama" value="<?php echo $nama ?>" placeholder="Dusan Vlahovic">
                        <label for="alamat"><i class="fa fa-address-card-o"></i> Address</label>
                        <input type="text" id="alamat" name="alamat" value="<?php echo $alamat ?>" placeholder="Denpasar St.">
                    </div>
                </div>
                <button type="submit" name="submit">Submit</button>
            </form>
        </div>
        <a class="btn" href="https://wa.me/6288217685721?text=Saya%20ingin%20melanjutkan%20transaksi..." target="_blank"><i class="fa fa-whatsapp"></i> Proceed to WhatsApp</a>

    </div>

    <footer style="position: fixed; right: 1em; bottom: 1em;">
        <a class="home" href="index.php">Back to Home</a>
    </footer>
    <footer style="background-color: #121212; padding: 0.7em; bottom: 0; left: 0; position: fixed">
        <h2 style="color:white; text-align:center; margin: -5px; padding-right: auto; font-size: 1em">threeknight.store</h2>
    </footer>
</body>

</html>