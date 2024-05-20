<?php include("connect.php"); ?>
<?php session_start() ?>

<!DOCTYPE html>
<html style="user-select: none;">
<meta http-equiv="X-UA-Compatible" content="ie=edge,chrome=1">
<meta name="handheldfriendly" content="true">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge,chrome=1">
  <meta name="handheldfriendly" content="true">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.1/css/all.min.css">
  <link href="output.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
  <script src="https://kit.fontawesome.com/2b335bb429.js" crossorigin="anonymous"></script>
</head>

<body>
  <header class="headerr" style="font-size: 18px!important">
    <?php
    if (isset($_SESSION['username'])) {
    ?>
      <a href="#home"><span style="margin: auto 7px auto 7px; float: left">home</span></a>
      <button style="float: left" onclick="cart()"><i class="fa fa-shopping-cart"></i></button>
      <a href="logout.php"><button style="margin: auto 7px auto 7px; float: right">logout</button></a>
      <a style="float: right; margin-right: 5px"><?php echo $_SESSION['username']; ?></a>
      <i class="fa fa-user" style="padding: 6px; float: right"></i>
    <?php
    } else {
    ?>
      <a href="#home"><span style="margin: auto 7px auto 7px">home</span></a>
      <a href="logres.php"><button class="logres" style="margin: auto 7px auto 7px">login or register</button></a>
    <?php
    }
    ?>
  </header>
  <header id="home" class="xlarge" style="background-color: #fff; width: 100%; height: 2em;"></header>

  <img src="images/header.jpg" class="top-web">
  <p class="shopnow" style="background-color: #fff;"><a href="#shirts">SHOP NOW</a></p>
  <img src="images/iklan.jpg" style="display: block; margin-left: auto; margin-right: auto; width: 100%; margin-bottom: 2.2em">

  <div class="cart hidden">
    <div class="isi-cart">
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
          echo "<form style='display: flex; align-items: center;'><input type='button' value='x' onclick='remove()' style='margin-right: 10px;'><span>" . $r2['nama_barang'] . ": " . $r1['jumlah'] . "</span></form>";
          $harga = $r2['harga'] * $r1['jumlah'];
          $total += $harga;
        }
        echo "<br><p> Total: IDR " . $total . "</p>";
      }
      ?>
    </div>
    <button class="proceed" onclick="window.location.href='payment.php'">Proceed to Payment</button>
  </div>

  <div id="shirts" style="justify-content: space-evenly">
    <?php
    $sql_cloth = "SELECT * FROM barang";
    $q_cloth = mysqli_query($cnn, $sql_cloth);

    while ($r_cloth = mysqli_fetch_array($q_cloth)) {
    ?>
      <?php $images = $r_cloth['foto']; ?>
      <a href="cart.php?id=<?php echo $r_cloth['id_barang'] ?>" onclick="document.getElementById('shirt1').style.display='block'" class="shirt-container">
        <img src="images/<?php echo $images ?>" class="shhover" alt="ELFORNITY" style="margin-bottom: 1em; cursor: pointer">
        <p> <?php echo $r_cloth['nama_barang']; ?></p>
        <p> IDR <?php echo $r_cloth['harga']; ?></p>
      </a>
    <?php
    }
    ?>
  </div>
</body>
<footer style="background-color: #121212; padding: 0.7em; bottom: 0; left: 0; position: fixed">
  <h2 style="color:white; text-align:center; margin: -5px; padding-right: auto">threeknight.store</h2>
</footer>
<footer style="padding: 0.7em; bottom: 0; left: 0"></footer>
<script type="text/javascript">
  function cart() {
    document.querySelector(".cart").classList.toggle("hidden");
  }
</script>

</html>