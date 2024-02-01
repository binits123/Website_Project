<?php
global $conn;
session_start();


$cart_count = 0;
require('dbconnect.php');
$status = "";
if (isset($_POST['action']) && $_POST['action'] == "remove") {
    if (!empty($_SESSION["shopping_cart"])) {
        unsetElementById($_SESSION["shopping_cart"], $_POST['id']);
        $status = "<div class='box' style='color:red;'> Product is removed from your cart!</div>";
    }
}

// Function to unset an element with a specific id
function unsetElementById(&$array, $id)
{
    foreach ($array as $key => $value) {
        if ($value['id'] === $id) {
            unset($array[$key]);
            return;
        }
    }
}


if (isset($_POST['action']) && $_POST['action'] == "change") {
    foreach ($_SESSION["shopping_cart"] as &$value) {
        if ($value['id'] === $_POST["id"]) {
            $value['quantity'] = $_POST["quantity"];
            break; // Stop the loop after we've found the product
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
    <link rel="stylesheet" href="assets/shoppingcart.css">
    <!-- <link rel="stylesheet" href="assets/productdetail.css"> -->
    <link rel="stylesheet" href="assets/header.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"> -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.6.0/css/all.min.css">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            /*border: 1px solid #dddddd;*/
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
            border-bottom: 2px solid #333; /* Adjust the color and size as needed */
            text-align: left;
        }

    </style>
    <title>Cart Page</title>
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
    <?php

    if (!empty($_SESSION["shopping_cart"])) {
        $cart_count = count(array_keys($_SESSION["shopping_cart"]));
    }
    ?>

    <div class="cart-icons">
        <button type="button" class="btn btn-success my-2 my-sm-0" data-toggle="modal"
                data-target="#paymentCartModal">
            <i class="fas fa-shopping-cart total-count">
                <?php echo $cart_count > 0 ? $cart_count : ''; ?>
            </i>
        </button>


    </div>

</header>
<div class="container2">
    <h2>Cart Details</h2>
    <hr>
    <!--    <p class="h1">Products</p>-->
    <!--    <p class="h2">Price</p>-->
    <!--    <p class="h3">Qty</p>-->
    <!--    <p class="h4">Total</p>-->
    <!--    <p class="h5">Action</p>-->
    <!--    <hr>-->
    <div class="cart">
        <?php
        if (isset($_SESSION["shopping_cart"])) {
            $total_price = 0;
            ?>
            <table style="width:100%">
                <thead>
                <tr>
                    <td></td>
                    <td><strong>PRODUCT</strong></td>
                    <td><strong>QUANTITY</strong></td>
                    <td><strong>PRICE</strong></td>
                    <td><strong>TOTAL</strong></td>
                    <td><strong>ACTION</strong></td>
                </tr>
                </thead>
                <tbody>

                <?php
                foreach ($_SESSION["shopping_cart"] as $product) {
                    ?>
                    <tr>
                        <td>
                            <img src='images/<?php echo $product["image"]; ?>' width="50" height="40"/>
                        </td>
                        <td><?php echo $product["name"]; ?><br/>

                        </td>
                        <td>
                            <form method='post' action=''>
                                <input type='hidden' name='id' value="<?php echo $product["id"]; ?>"/>
                                <input type='hidden' name='action' value="change"/>
                                <select name='quantity' onChange="this.form.submit()">
                                    <?php
                                    $maxSelection = $product["maxQuantity"];
                                    for ($i = 1; $i <= $maxSelection; $i++) {
                                        echo "<option " . ($product["quantity"] == $i ? "selected" : "") . " value=\"$i\">$i</option>";
                                    }
                                    ?>
                                </select>
                            </form>
                        </td>
                        <td><?php echo "$" . $product["price"]; ?></td>
                        <td><?php echo "$" . $product["price"] * $product["quantity"]; ?></td>
                        <td>
                            <form method='post' action=''>
                                <input type='hidden' name='id' value="<?php echo $product["id"]; ?>"/>
                                <input type='hidden' name='action' value="remove"/>
                                <button type='submit' class="value4">X</button>
                            </form>
                        </td>
                    </tr>
                    <?php
                    $total_price += ($product["price"] * $product["quantity"]);
                }
                ?>
                </tbody>
                <tfoot>
                <?php if ($total_price > 0) {
                    ?>
                    <tr>
                        <td colspan="5" align="right">
                            <strong>TOTAL:</strong>
                        </td>
                        <td  align="left">
                            <strong><?php echo "$" . $total_price; ?></strong>
                        </td>
                    </tr>
                    <?php

                } else { ?>
                    <tr></tr>
                    <tr>
                        <td colspan="5" style="text-align: center">
                            Your cart is empty!
                        </td>
                    </tr>
                    <?php
                } ?>

                </tfoot>

            </table>
            <?php
        } else {
            echo "<h3>Your cart is empty!</h3>";
        }
        ?>
    </div>
    <hr>
    <a href="shop.php" style="float: left">
        <button class="close" onclick="navigate('shop.php')">Cancel</button>
    </a>
    <?php if ($total_price > 0) { ?>
        <a href="checkout.php" style="margin-right: 20px">
            <button class="close" onclick="navigate('shop.html')">Checkout</button>
        </a>
    <?php } ?>
</div>
</body>

</html>
<script>
    // Get a reference to the div
    var myDiv = document.getElementById('messageBox');

    // Display the div
    myDiv.style.display = 'block';

    // Set a timeout to hide the div after 5000 milliseconds (5 seconds)
    setTimeout(function () {
        myDiv.style.display = 'none';
    }, 3000);
</script>