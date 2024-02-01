<?php
global $conn;
session_start();
$cart_count = 0;
require('dbconnect.php');
$status = "";
if (isset($_POST['productId']) && $_POST['productId'] != "") {
    $productId = $_POST['productId'];
    $result = mysqli_query(
        $conn,
        "SELECT * FROM `products` WHERE `id`=$productId"
    );
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

function getProducts()
{
    global $conn;
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);

    $products = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
    return $products;
}

$products = getProducts();

function trimDescription($description, $maxWords = 100) {
    $words = explode(' ', $description);
    $trimmedWords = array_slice($words, 0, $maxWords);
    $trimmedDescription = implode(' ', $trimmedWords);

    // Add ellipsis if there are more words in the original description
    if (count($words) > $maxWords) {
        $trimmedDescription .= '...';
    }

    return $trimmedDescription;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/shop.css">
    <link rel="stylesheet" href="assets/cart.css">
    <link rel="stylesheet" href="assets/header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.6.0/css/all.min.css">

    <title>product Page</title>
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
                    <div class="success"> </div> <?php echo $cart_count > 0 ? $cart_count : ''; ?>
                </i>
            </button>
        </a>


    </div>

</header>

<div class="header-container" style="margin-top: 110px;  text-align: center;   margin-bottom: -77px;">
    <h1> Our New Product</h1>
    <p> They are crafted in a variety of designs and patterns.</p>
    <div style="clear:both;"></div>

    <div class="message_box" style="margin:10px 0px;">
        <?php echo $status; ?>
        <?php if(isset($_SESSION['success_message'])){
          echo   $_SESSION['success_message'];
          unset($_SESSION['success_message']);
        }
        ?>
    </div>
</div>
<section id="product1" class="section-p1">

    <div class="pro-container">
        <?php foreach ($products as $key => $product): ?>
            <div class="pro">
                <form action="" method="post">
                    <input type='hidden' name='productId' value="<?php echo $product['id']; ?>"/>
                    <img src="images/products/<?php echo $product['image']; ?>">
                    <div class="des">
                        <h5>
                            <?php echo $product['name']; ?>
                        </h5>

                        <h4>
                            <?php echo trimDescription($product['description'],2); ?>
                        </h4>
                        <h4>Rs.
                            <?php echo $product['price']; ?>
                        </h4>

                    </div>
                    <!-- <a href="description.php&product_id=<?/*php echo $product['id']; */?>"> <input type="button" class="button1" value="View" > </a> -->
                    <a href="description.php?product_id=<?php echo $product['id']; ?>"><button type="button" class="default-btn border-radius-5">View</button></a>

                    <button type="submit" class="default-btn border-radius-5"> Add to cart</button>
                </form> 

            </div>
        <?php endforeach; ?>

    </div>
</section>
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
    }, 5000);
</script>