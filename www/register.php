<?php session_start();
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  header("location: index.php");
  exit;
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




  <section class="section_1 container-fluid p-0">
    <div class="d-flex flex-column">

      <!-- HEADER -->
      <?php include('templates/header.php'); ?>
      <!-- HEADER -->

      <!-- MAIN -->
      <form class="ms-4 me-4" method="post" enctype="multipart/form-data" action="check_information.php">

        <!-- ROLE SELECTING + FORM CHANGING -->
        <br>
        <h1>Register Information:</h1>
        <br>
        <p style="color:red;"> <b>(*): If the register process fails, please re-check if you meet the requirements below:</b> <br>
          - Username: contains only letters (lower and upper case) and digits, has a length from 8 to 15 characters, unique across the whole system <br>
          - Password: contains at least one upper case letter, at least one lower case letter, at least one digit, at least one special letter in the set !@#$%^&*, NO other kind of characters, has a length from 8 to 20 characters <br>
          - Other fields are required and have a minimum length of 5 characters (except the profile picture, which is a file upload, and the shipper's distribution hub, which is a drop-down select) <br>
          - The business name and business address are unique among the vendor accounts only (that means two vendors cannot have the same business address, but a vendor's business address can be the same as a customer's address) <br>

        </p>
        <p class="form-label">Choose your role: </p>
        <input class="form-check-input" onchange="displayVendor(this)" type="radio" name="role" id="vendor" value="vendor" checked="true">
        <label class="form-check-label" for="flexRadioDefault1">
          Vendor
        </label> <br>
        <input class="form-check-input" onchange="displayCustomer(this)" type="radio" name="role" id="customer" value="customer">
        <label class="form-check-label" for="flexRadioDefault2">
          Customer
        </label> <br>
        <input class="form-check-input" onchange="displayShipper(this)" type="radio" name="role" id="shipper" value="shipper">
        <label class="form-check-label" for="flexRadioDefault3">
          Shipper
        </label>
        <br> <br>
        <!-- ROLE SELECTING + FORM CHANGING -->

        <!-- VENDOR -->
        <div id="vendorField">
          <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" pattern="^(?=.{8,15}$)[a-zA-Z0-9]+$" class="form-control" name="vendorUsername" id="vendorUsername" placeholder="Username" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" pattern="^(?=.{8,20}$)(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]+$" class="form-control" name="vendorPassword" id="vendorPassword" placeholder="Password" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Business Name</label>
            <input type="text" pattern=".{5,}" class="form-control" name="vendorBusinessName" id="vendorBusinessName" placeholder="Business Name" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Business Address</label>
            <input type="text" pattern=".{5,}" class="form-control" name="vendorBusinessAddress" id="vendorBusinessAddress" placeholder="Business Address" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Profile Picture:</label>
            <input type="file" accept="image/*" id="vendorProfilePicture" name="vendorProfilePicture">
          </div>


          <!--
                <div class="mb-3 form-check">
                  <input type="checkbox" class="form-check-input" id="exampleCheck1">
                  <label class="form-check-label" for="exampleCheck1">Check me out</label>
                </div>
                -->

        </div>

        <!-- CUSTOMER -->
        <div id="customerField" style="display:none">
          <!-- HIDDEN BY DEFAULT -->
          <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" pattern="^(?=.{8,15}$)[a-zA-Z0-9]+$" class="form-control" name="customerUsername" id="customerUsername" placeholder="Username">
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" pattern="^(?=.{8,20}$)(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]+$" class="form-control" name="customerPassword" id="customerPassword" placeholder="Password">
          </div>
          <div class="mb-3">
            <label class="form-label">Customer Name</label>
            <input type="text" pattern=".{5,}" class="form-control" name="customerName" id="customerName" placeholder="Customer Name">
          </div>
          <div class="mb-3">
            <label class="form-label">Customer Address</label>
            <input type="text" pattern=".{5,}" class="form-control" name="customerAddress" id="customerAddress" placeholder="Customer Address">
          </div>
          <div class="mb-3">
            <label class="form-label">Profile Picture:</label>
            <input type="file" accept="image/*" id="customerProfilePicture" name="customerProfilePicture">
          </div>

        </div>

        <!-- SHIPPER -->
        <div id="shipperField" style="display:none">
          <!-- HIDDEN BY DEFAULT -->
          <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" pattern="^(?=.{8,15}$)[a-zA-Z0-9]+$" class="form-control" name="shipperUsername" id="shipperUsername" placeholder="Username">
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" pattern="^(?=.{8,20}$)(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]+$" class="form-control" name="shipperPassword" id="shipperPassword" placeholder="Password">
          </div>
          <div class="mb-3">
            <label for="floatingSelect" class="form-label">Select Distribution Hub</label>
            <select name="shipperDistributionHub" class="form-select" id="shipperDistributionHub" aria-label="Select your Distribution Hub to work at">
              <option selected value="DHL Supply Chain North America (Exel)">DHL Supply Chain North America (Exel)</option>
              <option value="UPS Facility">UPS Facility</option>
              <option value="DSV Warehouse">DSV Warehouse</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Profile Picture:</label>
            <input type="file" accept="image/*" id="shipperProfilePicture" name="shipperProfilePicture">
          </div>
        </div>

        <button name="checkinfo" type="submit" class="btn btn-primary">Submit</button>
      </form>
      <!-- MAIN -->

      <!-- FOOTER -->
      <?php include('templates/footer.php'); ?>
      <!-- FOOTER -->

      <script src="register_functions.js"></script>

    </div>
  </section>
</body>

</html>