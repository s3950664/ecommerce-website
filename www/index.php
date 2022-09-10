<?php session_start();
define('SECURE', true); ?>

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

  <!-- MAIN -->
  <section class="section_1 container-fluid p-0">
    <div class="d-flex flex-column">
      <div class="container-fluid text-center heading">
        <h1 class="h1">E-Commerce Website<br>Best place to trade</h1>
        <?php if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) : ?>
          <p class="p">Welcome to the website, please choose one of these options.</p>

          <a href="register.php"><button type="button" class="btn btn1 btn-secondary">Register</button></a>
          <a href="login.php"><button type="button" class="btn btn1 btn-secondary">Login</button></a>
        <?php else : ?>
          <?php echo ('<p class="p">Welcome to the website, <b>' . $_SESSION["username"] . '</b>!</p>') ?>
        <?php endif; ?>
      </div>
      <div class="container">
        <div class="row">
          <div class="col align-self-start">
            <img class="img-fluid" src="/rsc/HOMEPAGE1.png">
          </div>
          <div class="col align-self-end">
            <img class="img-fluid" src="/rsc/HOMEPAGE2.png">
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- MAIN -->


  <!-- FOOTER -->
  <?php include('templates/footer.php'); ?>
  <!-- FOOTER -->
</body>

</html>