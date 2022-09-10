<?php session_start();
if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}
if ($_SESSION["role"] != "vendor") {
    header("location: index.php");
    exit;
}
if (isset($_POST['addproduct'])) {


    $info = pathinfo($_FILES['productImage']['name']);
    $ext = $info['extension'];
    $newname = $_SESSION['username'] . "." . $ext;
    $target = '../database/product_image/' . $newname;

    $i = 0;
    //Upload Product Image
    while (file_exists($target)) {
        $i++;
        $newname = $_SESSION['username'] . "_" . $i . "." . $ext;
        $target = '../database/product_image/' . $newname;
    }

    move_uploaded_file($_FILES['productImage']['tmp_name'], $target);

    $products = file_get_contents('../database/products.db');
    $tempProductsArray = json_decode($products, true);

    //First Product
    if ($tempProductsArray == null) {
        $products_data['0'] = array('username' => $_SESSION['username'], 'product_id' => $i, 'product_name' =>  $_POST['productName'], 'product_price' => (int)$_POST['productPrice'], 'product_description' => $_POST['productDescription'], 'ext' => $ext);
        $jsonProductsData = json_encode($products_data);
    } else {
        $products_data = array('username' => $_SESSION['username'], 'product_id' => $i, 'product_name' =>  $_POST['productName'], 'product_price' => (int)$_POST['productPrice'], 'product_description' => $_POST['productDescription'], 'ext' => $ext);
        array_push($tempProductsArray, $products_data);
        $jsonProductsData = json_encode($tempProductsArray);
    }

    // Write to database
    file_put_contents('../database/products.db', $jsonProductsData);
    header("location: success.php");
}

?>

<!DOCTYPE html>
<html>

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
            <form class="ms-4 me-4 " method="post" enctype="multipart/form-data" action="add_product.php">
                <h1 class="pt-4 px-4">Add Product</h1>
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" pattern="^(?=.{10,20}$)+$" class="form-control" name="productName" id="productName" placeholder="Product Name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Price</label>
                    <input type="number" min="0" class="form-control" name="productPrice" id="productPrice" placeholder="Product Price" required>
                </div>
                <div class="mb-3">
                    <label for="productDescription">Description</label>
                    <textarea maxlength="500" class="form-control" name="productDescription" id="productDescription" placeholder="Write your product description here" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Product's Image:</label>
                    <input type="file" accept="image/*" id="productImage" name="productImage">
                </div>
                <button name="addproduct" type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </section>
    <!-- FOOTER -->
    <?php include('templates/footer.php'); ?>
    <!-- FOOTER -->
</body>

</html>