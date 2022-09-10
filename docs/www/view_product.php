<?php session_start();
if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}
if ($_SESSION["role"] != "vendor") {
    header("location: index.php");
    exit;
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
            <div class="ms-4 me-4">
                <h1 class="pt-4 px-4">My Products</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Product Price</th>
                            <th scope="col">Product Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $products = file_get_contents('../database/products.db');
                        $productsArray = json_decode($products, true);

                        if ($productsArray !== null) {
                            $i = 0;
                            foreach ($productsArray as $key => $item) {
                                if ($_SESSION['username'] == $item['username']) {
                                    echo ('<tr>
                                                <th scope="row">' . ($i + 1) . '</th>
                                                <td>' . $item['product_name'] . '</td>
                                                <td>' . $item['product_price'] . '</td>
                                                <td>' . $item['product_description'] . '</td>
                                            </tr>');
                                    $i++;
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <!-- FOOTER -->
    <?php include('templates/footer.php'); ?>
    <!-- FOOTER -->
</body>

</html>