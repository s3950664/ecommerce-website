<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Flex</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="styleAbout.css">

</head>

<body>


  <section>
    <!-- HEADER -->
    <?php include('templates/header.php'); ?>
    <!-- HEADER -->
  </section>
  <div class="about-section">
    <h1>About Us Page</h1>
    <p>Some text about who we are and what we do.</p>
    <p>Resize the browser window to see that this page is responsive by the way.</p>
  </div>

  <h2 style="text-align:center">Our Team</h2>
  <div class="row">
    <div class="column">
      <div class="card">
        <img src="/src/avatar4.png" alt="" style="width:20%">
        <div class="container">
          <h2>Tran Thien Tan</h2>
          <p class="title">Coder</p>
          <p>abc@gmail.com</p>
          <p><button class="button">Contact</button></p>
        </div>
      </div>
    </div>

    <div class="column">
      <div class="card">
        <img src="/src/avatar1.png" alt="" style="width:20%">
        <div class="container">
          <h2>Nguyen Phu Nhat Nam</h2>
          <p class="title">coder</p>
          <p>abc@gmail.com</p>
          <p><button class="button">Contact</button></p>
        </div>
      </div>
    </div>

    <div class="column">
      <div class="card">
        <img src="/src/avatar2.png" alt="" style="width:20%">
        <div class="container">
          <h2>Nguyen Tan Tan</h2>
          <p class="title">coder</p>
          <p>abc@gmail.com</p>
          <p><button class="button">Contact</button></p>
        </div>
      </div>
    </div>
    <div class="column">
      <div class="card">
        <img src="/src/avatar3.png" alt="" style="width:20%">
        <div class="container">
          <h2>Tran Duc Quy</h2>
          <p class="title">coder</p>
          <p>abc@gmail.com</p>
          <p><button class="button">Contact</button></p>
        </div>
      </div>
    </div>
  </div>
  <section>
    <!-- FOOTER -->
    <?php include('templates/footer.php'); ?>
    <!-- FOOTER -->
  </section>
</body>

</html>