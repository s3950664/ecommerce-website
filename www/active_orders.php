<?php session_start();
if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}
if ($_SESSION["role"] != "shipper") {
    header("location: index.php");
    exit;
}

if (isset($_POST['updatestatus'])) {
    if (isset($_POST['order_id'])) {
        if (($_POST['order_id'] != null) && (!empty($_POST['order_id']))) {
            $active_orders = json_decode(file_get_contents('../database/active_orders.db'), true);
            foreach ($_POST['order_id'] as $key => $item) {
                if ($item != 'active') {
                    foreach ($active_orders as $key2 => $item2) {
                        if ($key == $item2['order_id']) {
                            $active_orders[$key2]['status'] = $item;
                        }
                    }
                }
            }
            file_put_contents('../database/active_orders.db', json_encode($active_orders));
        }
    }
}


function initializeTable()
{
    #Get Working Hub
    $shipper = json_decode(file_get_contents('../database/shippers.db'), true);
    foreach ($shipper as $key => $item) {
        if ($_SESSION['username'] == $item['username']) {
            $working_hub = $item['distribution_hub'];
        }
    }

    #Get orders
    $active_orders = json_decode(file_get_contents('../database/active_orders.db'), true);

    $i = 0;
    foreach ($active_orders as $key => $item) {
        if ($item['status'] == 'active') {
            if ($item['hub_name'] == $working_hub) {
                echo ('<tr id="' . $item['order_id'] . '"><th scope="row">' . ($i + 1) . '</th><td>');
                $j = 0;
                foreach ($item['products'] as $key => $product) {
                    echo ('<details>
                        <summary style="font-weight: bold;">Product ' . ($j + 1) . '</summary>
                        <p>Product Name: ' . $product['product_name'] . '</p>
                        <p>Vendor: ' . $product['vendor'] . '</p>
                        <p>Product ID (of vendor based on product name): ' . $product['product_id'] . '</p>
                        <p>Product Price: ' . $product['product_price'] . '</p>
                        </details>');
                    $j++;
                }
                echo ('</td>');
                echo ('<td>' . $item['hub_name'] . '</td>
                        <td>' . $item['customer_address'] . '</td>
                        <td>' . $item['total_price'] . '</td>');
                echo ('<td><select name="order_id[' . $item['order_id'] . ']" id="' . $item['order_id'] . '">
                        <option value="active">Active</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                        </select></td>');
                $i++;
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

<body onload=";">
    <!-- <script src="shopping_cart.js"></script> -->
    <!-- HEADER -->
    <?php include('templates/header.php'); ?>
    <!-- HEADER -->
    <section class="section_1 container-fluid p-0">
        <div class="d-flex flex-column">
            <div class="ms-4 me-4">
                <form id="#" method="post">
                    <h1 class=" pt-2 px-4">Active Orders</h1>
                    <h1 class=" pt-2 px-4">

                        <?php
                        $shipper = json_decode(file_get_contents('../database/shippers.db'), true);
                        foreach ($shipper as $key => $item) {
                            if ($_SESSION['username'] == $item['username']) {
                                echo ('Hub: ' . $item['distribution_hub']);
                                echo ('<br><br>');
                            }
                        }
                        ?>
                    </h1>

                    <p style="color:red">(*): Once you update the status from Active to Delivered or Cancelled, you will not be able to reverse the change. The new status will be saved in the database and only database managers can modify it.</p>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Products</th>
                                <th scope="col">Distribution Hub</th>
                                <th scope="col">Customer Address</th>
                                <th scope="col">Total Price</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody id="table">
                            <?php
                            initializeTable();
                            ?>
                        </tbody>
                    </table>
                    <button name="updatestatus" type="submit" class="btn btn-primary">Update Status</button>
                </form>
            </div>
        </div>
    </section>
    <!-- FOOTER -->
    <?php include('templates/footer.php'); ?>
    <!-- FOOTER -->

</body>

</html>