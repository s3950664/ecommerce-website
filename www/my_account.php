<?php session_start();
if (!isset($_SESSION["loggedin"]) && !$_SESSION["loggedin"] === true) {
  header("location: index.php");
  exit;
}

$username = $_SESSION["username"];
$role = $_SESSION["role"];

if ($role == "vendor") {
  $business = json_decode(file_get_contents('../database/business.db'), true);
  foreach ($business as $key => $item) {
    if ($item["username"] == $username) {
      $business_name = $item["business_name"];
      $business_address = $item["business_address"];
    }
  }
}

if ($role == "customer") {
  $customer = json_decode(file_get_contents('../database/customers.db'), true);

  foreach ($customer as $key => $item) {
    if ($item["username"] == $username) {
      $customer_name = $item["customer_name"];
      $customer_address = $item["customer_address"];
    }
  }
}

if ($role == "shipper") {
  $shipper = json_decode(file_get_contents('../database/shippers.db'), true);
  foreach ($shipper as $key => $item) {
    if ($item["username"] == $username) {
      $distribution_hub = $item["distribution_hub"];
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

      <div class="px-5 pt-5">
        <h1>My Account</h1>
        <div class="mb-3">
          <?php echo ('<label class="form-label">Username: </label> <span>' . $username . '</span><br>'); ?>
          <?php echo ('<label class="form-label">Role: </label> <span>' . $role . '</span><br>'); ?>
          <?php if ($role == "vendor") {
            echo ('<label class="form-label">Business Name: </label> <span>' . $business_name . '</span><br>');
            echo ('<label class="form-label">Business Address: </label> <span>' . $business_address . '</span><br>');
          }
          if ($role == "customer") {
            echo ('<label class="form-label">Customer Name: </label> <span>' . $customer_name . '</span><br>');
            echo ('<label class="form-label">Customer Address: </label> <span>' . $customer_address . '</span><br>');
          }
          if ($role == "shipper") {
            echo ('<label class="form-label">Distribution Hub: </label> <span>' . $distribution_hub . '</span><br>');
          }
          echo ('<label class="form-label">Profile Picture: </label><br>');

          //Very depressing process of getting image out of root directory :)
          $file = glob('../database/profile_picture/' . $username . '.*');
          $file = $file[0];
          $path_parts = pathinfo($file);
          echo ('<img style="max-width:100%; max-height:100%; height: 300px; width: 300px;" src="image.php?img=' . $path_parts['dirname'] . "/" . $path_parts['basename'] . '"/><br><br>')
          ?>
          <?php
          echo ('<form class="ms-4 me-4" method="post" enctype="multipart/form-data" action="change_profile_picture.php">
                <div class="mb-3">
                    <label class="form-label">Change Profile Picture:</label>
                    <input type="file" accept="image/*" id="changeProfilePicture" name="changeProfilePicture">
                  </div>
                </div>
                
                <button name="changepp" type="submit" class="btn btn-primary">Submit</button>
                </form>');
          ?>


        </div>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <?php include('templates/footer.php'); ?>
  <!-- FOOTER -->
</body>

</html>