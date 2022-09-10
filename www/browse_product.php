<?php session_start();
if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}
if ($_SESSION["role"] != "customer") {
    header("location: index.php");
    exit;
}



function displayCard(array $product_from_array)
{
    //Construct product filename
    if ($product_from_array['product_id'] == 0) {
        $product_name_only = $product_from_array['username'];
    } else {
        $product_name_only = $product_from_array['username'] . "_" . $product_from_array['product_id'];
    }

    $name_with_ext = $product_name_only . '.' . $product_from_array['ext'];

    //Get image names
    $file = glob('../database/product_image/' . '*.*');
    $basename = [];
    $filename = [];
    $dirname = [];
    $extension = [];

    foreach ($file as $key => $item) {
        $filename[$key] = pathinfo($item)['filename'];
        $basename[$key] = pathinfo($item)['basename'];
        $dirname[$key] = pathinfo($item)['dirname'];
        $extension[$key] = pathinfo($item)['extension'];
    }


    //Check if it matches
    foreach ($basename as $key => $item) {
        if ($item === $name_with_ext) {
            $dir = $dirname[$key];
            $base = $basename[$key];
        }
    }


    echo ('<div class="card" style="width: 18rem;">
    <img style="max-width:100%; max-height:100%; height: 300px; width: 300px;" class="card-img-top" src="image.php?img=' . $dir . "/" . $base . '"/>
    <div class="card-body" id="' . $name_with_ext . '">
        <h5 class="card-title"> <span class="product_name">' . $product_from_array['product_name'] . '</span></h5>
        <p class="card-text">Vendor: <span class="username">' . $product_from_array['username'] . '</span></p>
        <p class="card-text">Price: <span class="product_price">' . $product_from_array['product_price'] . '</span></p>
        <p class="card-text">Product ID: <span class="product_name_only">' . $product_name_only . '</span></p>
        <p class="card-text">Product ID (of vendor based on product name): <span class="product_id">' . $product_from_array['product_id'] . '</span></p>
        <p class="card-text">Description: <span class="product_description">' . $product_from_array['product_description'] . '</span></p>
        <a href="#" onclick="addToCart(\'' . $name_with_ext . '\')" class="btn btn-primary">Add to cart</a>
    </div>
    </div>');
}

function initializeGrid($minPrice, $maxPrice, $productName)
{
    $products = file_get_contents('../database/products.db');
    $productsArray = json_decode($products, true);

    if (!empty($minPrice) || !empty($maxPrice) || !empty($productName)) {

        if (!isset($minPrice) || $minPrice == 0 || $minPrice == null) {
            $minPrice = 0;
        }
        if (!isset($maxPrice) || $maxPrice == 0 || $maxPrice == null) {
            $maxPrice = 99999999;
        }
        if (isset($minPrice) && isset($maxPrice)) {
            if ($minPrice > $maxPrice) {
                $x = $maxPrice;
                $maxPrice = $minPrice;
                $minPrice = $x;
            }
        }
        if (!isset($productName) || $productName == '' || $productName == null) {
            $productName = "";
        }


        $z = 0;
        $realProductsArray = [];

        foreach ($productsArray as $key => $item) {
            if (($item['product_price'] >= $minPrice) && ($item['product_price'] <= $maxPrice)) {
                if ($item['product_name'] == $productName) {
                    $realProductsArray[$z] = $item;
                    $z++;
                } elseif (str_contains($item['product_name'], $productName)) {
                    $realProductsArray[$z] = $item;
                    $z++;
                }
            }
        }

        $productsArray = $realProductsArray;
    }

    if ($productsArray !== null) {
        $i = 0;
        while ($i + 1 <= sizeof($productsArray)) {

            // END OF DIV
            if (($i + 1) % 3 == 0) {
                //One of three columns

                echo ('<div class="col">');
                displayCard($productsArray[$i]);
                echo ('</div>');

                //LAST DIV LINE
                echo ('</div>');
                echo ('<br>');

                // START OF DIV
            } else {
                if (($i + 1) % 3 == 1) {

                    echo ('<div class="row">');
                }

                echo ('<div class="col">');
                displayCard($productsArray[$i]);
                echo ('</div>');
            }

            $i++;
        }
        if (sizeof($productsArray) % 3 != 0) {
            if (sizeof($productsArray) % 3 == 1) {
                echo ('<div class="col">');
                echo ('</div>');
                echo ('<div class="col">');
                echo ('</div>');
                echo ('</div>');
            } else {
                echo ('<div class="col">');
                echo ('</div>');
                echo ('</div>');
            }
        }
    }
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

<body onload="redify();">

    <!-- HEADER -->
    <?php include('templates/header.php'); ?>
    <!-- HEADER -->
    <section class=" section_1 container-fluid p-0">
        <div class="d-flex flex-column">
            <div class="ms-4 me-4">
                <h1 class="pt-4 px-4">Browse Products</h1>
                <div class="container">
                    <form method="get" action="browse_product.php">
                        <div class="mb-3">
                            <label class="form-label">Price Min</label>
                            <input type="number" min="0" class="form-control" name="minPrice" id="minPrice" placeholder="Price"> <br>
                            <label class="form-label">Price Max</label>
                            <input type="number" min="0" class="form-control" name="maxPrice" id="maxPrice" placeholder="Price"> <br>
                            <label class="form-label">Name Filter</label>
                            <input type="text" pattern="^(?=.{10,20}$)+$" class="form-control" name="productName" id="productName" placeholder="Name"> <br>
                        </div>
                        <button name="filter" type="submit" class="btn btn-primary">Filter</button> <br> <br> <br>
                    </form>
                    <?php
                    unset($_GET['filter']);
                    if (isset($_GET['filter'])) {
                        header('location: browse_product.php?minPrice=' . $_GET['minPrice'] . '&maxPrice=' . $_GET['maxPrice'] . '&productName=' . $_GET['productName']);
                    }

                    if (!empty($_GET)) {

                        initializeGrid($_GET['minPrice'], $_GET['maxPrice'], $_GET['productName']);
                    } else {
                        initializeGrid(null, null, null);
                    }

                    ?>
                </div>
            </div>
        </div>
    </section>
    <!-- FOOTER -->
    <?php include('templates/footer.php'); ?>
    <!-- FOOTER -->
    <script src="localstorage_functions.js"></script>
</body>

</html>