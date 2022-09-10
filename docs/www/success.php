<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="refresh" content="3;url=index.php" />
  <title>E-commerce Website</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <!-- HEADER -->
  <?php include('templates/header.php'); ?>
  <!-- HEADER -->
  <section class="section_1 container-fluid p-0 mt-5">
    <div class="container-fluid text-center heading">
      <h1>Succeeded, redirect to index after 3 seconds</h1>
    </div>
  </section>
  <!-- FOOTER -->
  <?php include('templates/footer.php'); ?>
  <!-- FOOTER -->
</body>

</html>