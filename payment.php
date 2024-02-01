<?php
global $conn;
session_start();
require('dbconnect.php');
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $selectedPayment = $_POST["payment"];
    $action = $_POST["action"];

    // Perform actions based on the selected payment method and action
    if ($action === "confirm") {
        $customerId = $_SESSION["shopping_cart_customer"]['customer_id'];
        $currentDate = date("Y-m-d");

        $cashOnDelivery = $selectedPayment;
        $total_price = 0;
        foreach ($_SESSION["shopping_cart"] as $product) {
            $total_price += ($product["price"] * $product["quantity"]);
        }

        $sql = "INSERT INTO orders (customer_id, total_price, payment_method, order_date)
         VALUES ($customerId, $total_price, '$cashOnDelivery', '$currentDate')";

        $orderResults = mysqli_query($conn, $sql);
        $orderId="";
        $productArrs = [];
        if ($orderResults && $_SESSION["shopping_cart"]) {
            $orderId = mysqli_insert_id($conn);
            $productArrs = [];
            foreach ($_SESSION["shopping_cart"] as $product) {
                $productId = $product["id"];

                $sql = "SELECT * FROM products WHERE id = $productId";
                $result = mysqli_query($conn, $sql);

                $productData = ($result->num_rows > 0) ? $result->fetch_assoc() : [];

                if ($productData) {
                    $name = $productData['name'];
                    $price = $productData['price'];
                    $quantity = $product['quantity'];
                    $total = $productData['price'] * $product['quantity'];

                    $sql = "INSERT INTO order_products (order_id,product_id, price, quantity)
                VALUES ($orderId,$productId, $price, $quantity)";

                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        $productArrs[] = mysqli_insert_id($conn);

                    }
                }
            }

            if ($productArrs) {
                session_unset();
                // Start the session
                session_start();
//                $_SESSION['success_message'] = "Your payment has been confirmed successfully!";

                header("Location: thankyou.php?order_id=$orderId");
                exit(); //
            }

        }
    } elseif ($action === "cancel") {
        // Handle cancellation logic
        header("Location: cart.php");
        exit(); //
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-5">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>paymentmethod</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="assets/header.css">
    <link rel="stylesheet" href="assets/payment.css">
</head>
<body>

<header class="header">
    <a href="#" class="logo">XYZshoe</a>
    <nav class="navbar">
        <a href="home.html">HOME</a>
        <a href="login.html">LOG IN</a>
        <a href="shop.html">SHOP</a>
        <a href="contactus.html">CONTACT</a>
        <a href="aboutus.html">ABOUT US</a>
    </nav>
</header>
<div class="container">
    <div class="title">
        <h4>Select a <span style="color: rgb(144, 5, 123)">Payment </span>method</h4>
    </div>

    <form method="post" name="paymentForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

        <input type="radio" name="payment" id="card" value="card" disabled>
        <input type="radio" name="payment" id="cash" value="cash">
        <input type="radio" name="payment" id="paypal" value="paypal" disabled>
        <input type="radio" name="payment" id="esewa" value="esewa" disabled>

        <div class="category">
            <label for="card" class="cardMethod">
                <div class="imgname">
                    <div class="imgcontainer card">
                        <img src="images/visa.png" alt="">
                    </div>
                    <span class="name">Credit Card</span>
                </div>
                <span class="check"><i class="fa-sharp fa-solid fa-circle-check" style="color: #6064b6;"></i></span>
            </label>
            <label for="cash" class="cashMethod">
                <div class="imgname">
                    <div class="imgcontainer cash">
                        <img src="images/cash.png" alt="">
                    </div>
                    <span class="name">Cash on Delivery</span>
                </div>
                <span class="check"><i class="fa-sharp fa-solid fa-circle-check" style="color: #6064b6;"></i></span>
            </label>
            <label for="paypal" class="paypalMethod">
                <div class="imgname">
                    <div class="imgcontainer paypal">
                        <img src="images/paypal.png" alt="">
                    </div>
                    <span class="name">Paypal</span>
                </div>
                <span class="check"><i class="fa-sharp fa-solid fa-circle-check" style="color: #6064b6;"></i></span>
            </label>
            <label for="esewa" class="esewaMethod">
                <div class="imgname">
                    <div class="imgcontainer esewa">
                        <img src="images/esewa.png" alt="">
                    </div>
                    <span class="name">Esewa</span>
                </div>
                <span class="check"><i class="fa-sharp fa-solid fa-circle-check" style="color: #6064b6;"></i></span>
            </label>
        </div>

        <div class="confirm">
            <button type="submit" name="action" value="cancel" class="cancel-button">Cancel</button>
            <button type="button" onclick="onConfirmClick()" class="confirm-button">Confirm</button>
        </div>
    </form>
</div>
</body>
<script>
    function validateForm() {
        // Get all radio buttons with name "payment"
        var paymentOptions = document.getElementsByName("payment");

        // Check if at least one radio button is checked
        var isChecked = false;
        for (var i = 0; i < paymentOptions.length; i++) {
            if (paymentOptions[i].checked) {
                isChecked = true;
                break;
            }
        }

        // Display an alert if no radio button is checked
        if (!isChecked) {
            alert("Please select a payment method before submitting.");
            return false; // Prevent form submission
        }

        return true; // Allow form submission
    }

    function onConfirmClick() {
        if (validateForm()) {
            // Set a hidden input with name "action" and value "confirm"
            var hiddenInput = document.createElement("input");
            hiddenInput.setAttribute("type", "hidden");
            hiddenInput.setAttribute("name", "action");
            hiddenInput.setAttribute("value", "confirm");

            // Append the hidden input to the form
            document.forms["paymentForm"].appendChild(hiddenInput);

            
            document.forms["paymentForm"].submit();
        }
    }
</script>