<?php
global $conn;
session_start();
require('dbconnect.php');
$orderId = $_GET['order_id'] ?? 0;

function getOrderDetails($orderId)
{
    global $conn;
    $sqlOrder = "SELECT orders.*, customers.f_name, customers.l_name, customers.email, customers.address
                 FROM orders
                 JOIN customers ON orders.customer_id = customers.id
                 WHERE orders.id = $orderId";

    $orderResult = mysqli_query($conn, $sqlOrder);

    $orderData = ($orderResult->num_rows > 0) ? $orderResult->fetch_assoc() : [];
    $sqlOrderProducts = "SELECT order_products.*,products.image, products.name AS product_name 
                     FROM order_products 
                     JOIN products ON order_products.product_id = products.id
                     WHERE order_products.order_id = $orderId";

    $orderProductResults = $conn->query($sqlOrderProducts);
    $products = [];

    if ($orderProductResults->num_rows > 0) {
        while ($row = $orderProductResults->fetch_assoc()) {
            $products[] = $row;
        }
    }
    if ($orderData) {
        $orderData['products'] = $products;
    }


    return $orderData;
}

$order = getOrderDetails($orderId);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/shoppingcart.css">
    <link rel="stylesheet" href="assets/thankyou.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.6.0/css/all.min.css">
    <style>
        .thankyou-container {
            max-width: 800px;
            margin: 100px auto;
            padding: 20px;
        }

        .thank-you-message {
            background-color: #f5f5f5;
            padding: 10px;
            margin-bottom: 20px;
        }

        .order-summary {
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #ddd;
        }

        .order {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
    <title>Thankyou Page</title>
</head>

<body>

<header class="header">
    <a href="#" class="logo">XYZshoe</a>

    <nav class="navbar">
        <a href="welcome.php">HOME</a>
        <a href="index.php">LOG IN</a>
        <a href="shop.php">SHOP</a>
        <a href="contactus.php">CONTACT</a>
        <a href="aboutus.php">ABOUT US</a>
    </nav>
</header>
<div class="thankyou-container">

    <h1>Thank You for Shopping with Us !</h1>

    <div class="thank-you-message">
        <p><?php echo $order['f_name']." ".$order['l_name']; ?>,Your order has been successfully placed.</p>
    </div>

    <div class="order-summary">
        <h2>Order Summary</h2>
        <?php
        // Display orders

        echo "<div class='order'>";
        echo "<h4>Order ID: {$order['id']}</h4>";
        echo "<h4>Order Date: {$order['order_date']}</h4>";
        echo "<h4>Total Amount: {$order['total_price']}</h4>";
        echo "<h4>Payment Method: {$order['payment_method']}</h4>";

        // Display order products in a table
        echo "<h4>Order Product Details:</h4>";
        echo "<table>";
        echo "<tr><th></th><th>Product Name</th><th>Quantity</th><th>Price</th></tr>";
        foreach ($order['products'] as $product) {
            echo "<tr>";
            echo "<td><img src='images/{$product['image']}'></td>";
            echo "<td>{$product['product_name']}</td>";
            echo "<td>{$product['quantity']}</td>";
            echo "<td>{$product['price']}</td>";
            echo "</tr>";
        }
        echo "</table>";


        echo "</div>";
        ?>
    </div>
    <a href="shop.php"> <button class="shopagain" >Shop again</button></a>

</div>


</body>
</html>