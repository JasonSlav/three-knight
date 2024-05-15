<?php include("connect.php"); ?>
<?php session_start() ?>
<?php
$username = "";
$password = "";

$confirm = "";

$error = "";
$success = "";

if (isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  if ($username == '' or $password == '') {
    $error = "All fields are required";
  } elseif (strlen($username) < 4) {
    $error = "Username must be at least 4 characters long";
  } elseif (strlen($password) < 4) {
    $error = "Password must be at least 4 characters long";
  } else {
    $sql1 = "SELECT * FROM atmin WHERE username = '$username' AND password = md5('$password')";
    $q1 = mysqli_query($cnn, $sql1);
    if (mysqli_num_rows($q1) < 1) {
      $error = "Invalid username or password";
    }
  }

  if (empty($error)) {
    $_SESSION['username'] = $username;
    header("location: atmin.php");
    exit();
  }
}

if (isset($_POST['register'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $confirm = $_POST['confirm'];

  if ($username == '' or $password == '' or $confirm == '') {
    $error = "All fields are required";
  } elseif (strlen($username) < 4) {
    $error = "Username must be at least 4 characters long";
  } elseif ($password != $confirm) {
    $error = "Passwords do not match";
  } elseif (strlen($password) < 4) {
    $error = "Password must be at least 4 characters long";
  } else {
    $sql1 = "SELECT * FROM atmin WHERE username = '$username' AND username = '$username'";
    $q1 = mysqli_query($cnn, $sql1);
    if (mysqli_num_rows($q1) > 0) {
      $error = "User already exists";
    }
  }

  if (empty($error)) {
    $sql1 = "INSERT INTO atmin (username, password) VALUES ('$username', md5('$password'))";
    $q1 = mysqli_query($cnn, $sql1);

    if ($q1) {
      $success = "Registration successful";
      $_SESSION['username'] = $username;
      header("location: atmin.php");
      exit();

    } else {
      $error = "Registration failed";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login & Registration Form</title>
  <link rel="stylesheet" href="logres.css">
</head>

<body>
  <div class="container">
    <input type="checkbox" id="check">
    <div class="login form">
      <header>ADMIN Login</header>
      <?php if ($error) {
        echo $error;
      } ?>
      <form action="admin.php" method="post">
        <input type="text" name="username" placeholder="Enter your username">
        <input type="password" name="password" placeholder="Enter your password">
        <a href="#">Forgot password?</a>
        <input type="submit" name="login" class="button" value="Login">
      </form>
      <div class="signup">
        <span class="signup">Don't have an account?
          <label for="check">Register</label>
        </span>
      </div>
    </div>
    <div class="registration form">
      <header>ADMIN Register</header>
      <?php if ($error) {
        echo $error;
      } ?>
      <form action="admin.php" method="post">
        <input type="text" name="username" placeholder="Enter your username">
        <input type="password" name="password" placeholder="Create a password">
        <input type="password" name="confirm" placeholder="Confirm your password">
        <input type="submit" name="register" class="button" value="Register">
      </form>
      <div class="signup">
        <span class="signup">Already have an account?
          <label for="check">Login</label>
        </span>
      </div>
    </div>
  </div>
</body>

</html>