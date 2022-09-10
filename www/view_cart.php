<?php session_start();
if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}
if ($_SESSION["role"] != "customer") {
    header("location: index.php");
    exit;
}

if (isset($_POST['save_orders'])) {
    if (!empty($_POST['product']) && $_POST['product'] != null) {
        $customer = json_decode(file_get_contents('../database/customers.db'), true);
        foreach ($customer as $key => $item) {
            if ($item['username'] == $_SESSION['username']) {
                $customer_address = $item['customer_address'];
            }
        }

        $totalPrice = 0;
        $product = $_POST['product'];
        foreach ($product as $key => $item) {
            $totalPrice = $totalPrice + $item['product_price'];
        }

        $dis_hub = json_decode(file_get_contents('../database/distribution_hubs.db'), true);
        $rand_hub = $dis_hub[array_rand($dis_hub)];

        $a_o = json_decode(file_get_contents('../database/active_orders.db'), true);
        if ($a_o == null) {
            $a_o = [];
        }

        $arr = array('products' => $product, 'order_id' => sizeof($a_o), 'total_price' => $totalPrice, 'customer_address' => $customer_address, 'hub_name' => $rand_hub['distribution_hub'], 'status' => 'active');


        $active_ord = json_decode(file_get_contents('../database/active_orders.db'), true);
        if ($active_ord == null) {
            $active_ord = [];
        }
        array_push($active_ord, $arr);
        $active_ord = json_encode($active_ord);
        file_put_contents('../database/active_orders.db', $active_ord);
        header('location: view_cart.php');
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

<body onload="initialize();">
    <script src="shopping_cart.js"></script>
    <!-- HEADER -->
    <?php include('templates/header.php'); ?>
    <!-- HEADER -->
    <section class="section_1 container-fluid p-0">
        <div class="d-flex flex-column">
            <div class="ms-4 me-4">
                <form id="shoppping-cart-form" method="post">
                    <h1 class=" pt-4 px-4">Shopping Cart</h1> <br>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Vendor</th>
                                <th scope="col">Product ID (of vendor based on product name)</th>
                                <th scope="col">Product Price</th>
                                <th scope="col">Product Description</th>
                                <th scope="col">Remove</th>
                            </tr>
                        </thead>
                        <tbody id="table">
                            <!--INITIALIZE PROCESS-->
                        </tbody>
                    </table>
                    <button onclick="deleteLocalStorage();" name="save_orders" type="submit" class="btn btn-primary">Check out</button>
                </form>
            </div>
        </div>
    </section>
    <!-- FOOTER -->
    <?php include('templates/footer.php'); ?>
    <!-- FOOTER -->

</body>

</html>