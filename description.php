<?php
global $conn;
$error = $success = "";
$sql = "";
$cart_count = 0;
$status = "";
// print_r($productID); die("122121121212");
$productId = isset($_GET['product_id']) ? $_GET['product_id'] : null;
session_start();
require('dbconnect.php');

if (isset($_POST['productId']) && $_POST['productId'] != "") {
    $productId = $_POST['productId'];
    $result = mysqli_query(
        $conn,
        "SELECT * FROM `products` WHERE `id`=$productId"
    );
    // print_r($_POST); die("1111111");
    $row = mysqli_fetch_assoc($result);

    $name = $row['name'];
    $description = $row['description'];
    $price = $row['price'];
    $quantity = $row['quantity'];
    $image = $row['image'];
    $cartArray = array(
        $productId => array(
            'id' => $row['id'],
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'quantity' => 1,
            'maxQuantity' => $quantity,
            'image' => $image
        )
    );
    // print_r($cartArray); die("1111111");
    if (empty($_SESSION["shopping_cart"])) {
        // If the shopping cart is empty, simply set the cartArray
        $_SESSION["shopping_cart"] = $cartArray;
        $status = "<div class='box' id='messageBox'>Product is added to your cart!</div>";
    } else {

        // If the shopping cart is not empty, check if the product already exists
        $cartIds = array_column($_SESSION["shopping_cart"], 'id');

        $existingProduct = in_array($productId, $cartIds);

        if ($existingProduct) {
            // Product already exists in the cart
            $status = "<div class='box'  id='messageBox' style='color:red;'> Product is already added to your cart!</div>";
        } else {
            // Product does not exist in the cart, merge the arrays
            $_SESSION["shopping_cart"] = array_merge($_SESSION["shopping_cart"], $cartArray);
            $status = "<div class='box'  id='messageBox'>Product is added to your cart!</div>";
        }
    }
}

$sql = "SELECT * FROM products WHERE id = $productId";
$result = mysqli_query($conn, $sql);
$products = [];

// print_r($products); die("11122222");
//return ($result->num_rows > 0) ? $result->fetch_assoc() : null;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products = $row;
    }

}
// print_r($products); die("111");


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" href="assets/productdetail.css">
    <link rel="stylesheet" href="assets/header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.6.0/css/all.min.css">

    <title>Products details</title>
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
            <a href="cart.php">
                <button type="button" class="btn btn-success my-2 my-sm-0" data-toggle="modal"
                    data-target="#paymentCartModal">
                    <i class="fas fa-shopping-cart total-count">
                        <div class="success"> </div>
                        <?php echo $cart_count > 0 ? $cart_count : ''; ?>
                    </i>
                </button>
            </a>


        </div>
    </header>

    <div class="smallcontainer single-product">


        <div class="row">
            <div class="col-2">
                <img src="images/products/<?php echo $products['image']; ?>" width="100%" alt="Product Image">
            </div>
            <div class="col-2">
                <div class="message_box" style="margin-bottom: 30px; margin-top: -32px;">

                    <?php echo $status; ?>
                    <?php if (isset($_SESSION['success_message'])) {
                        echo $_SESSION['success_message'];
                        unset($_SESSION['success_message']);
                    }
                    ?>
                </div>
                <h2>
                    <?php echo $products['name'] ?>

                </h2>
                <h4>
                    Rs: <?php echo $products['price'] ?>

                </h3>
                <br><br>
               
                <br/>
                <h3>Product details</h3>
                <br>
                <p style="line-height: 1.2em !important;">
                    <?php echo $products['description'] ?>
                </p>
                <form action="" method="post">
                    <input type='hidden' name='productId' value="<?php echo $products['id']; ?>" />
                    <button type="submit" class="btn">Add to cart</button>
                </form> 
            </div>
        </div>
    </div>


</body>
<script>
    // Get a reference to the div
    var myDiv = document.getElementById('messageBox');

    // Display the div
    // alert("aaa");
    myDiv.style.display = 'block';

    // Set a timeout to hide the div after 5000 milliseconds (5 seconds)
    setTimeout(function () {
        // myDiv.innerHTML= '';
    }, 5000);
</script>

</html>