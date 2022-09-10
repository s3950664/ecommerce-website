<?php
session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  header("location: index.php");
  exit;
}

if (isset($_POST['loginprocess'])) {

  //Get username + password from client
  $username = $_POST['username'];
  $password = $_POST['password'];

  //Get role
  $account = file_get_contents('../database/accounts.db');
  $tempAccountArray = json_decode($account, true);
  foreach ($tempAccountArray as $key => $item) {
    if ($item["username"] == $username) {
      $role = $item["role"];
    }
  }

  //Validate user
  if (verifyUser($username, $password) == true) {

    $_SESSION["loggedin"] = true;
    $_SESSION["username"] = $username;
    $_SESSION["role"] = $role;

    header("location: success.php");
  } else {
    header("location: fail.php");
  }
}

function verifyUser($username, $password)
{
  $content = json_decode(file_get_contents('../database/accounts.db'), true);

  if ($content != null) {
    foreach ($content as $key => $item) {
      if ($username == $item['username']) {
        if (password_verify($password, $item['password'])) {
          return true;
        }
      }
    }
    return false;
  } else {
    return false;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>E-commerce Website</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">

</head>

<body>


  <!-- HEADER -->
  <?php include('templates/header.php'); ?>
  <!-- HEADER -->

  <section class="section_1 container-fluid p-0">
    <div class="d-flex flex-column">


      <!-- MAIN -->
      <form class="ms-4 me-4" method="post" action="login.php">


        <br>
        <h1>Login to E-Commerce Website</h1>
        <br>

        <div class="mb-3">
          <label class="form-label">Username</label>
          <input type="text" pattern="^(?=.{8,15}$)[a-zA-Z0-9]+$" class="form-control" name="username" id="username" placeholder="Username" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" pattern="^(?=.{8,20}$)(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]+$" class="form-control" name="password" id="password" placeholder="Password" required>
        </div>

        <button name="loginprocess" type="submit" class="btn btn-primary">Login</button>
      </form>
      <!-- MAIN -->

    </div>
  </section>

  <!-- FOOTER -->
  <?php include('templates/footer.php'); ?>
  <!-- FOOTER -->
</body>

</html>