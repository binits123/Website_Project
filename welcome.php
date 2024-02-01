<?php
global $conn;
session_start();
require('dbconnect.php');
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home page</title>
    <link rel="stylesheet" href="assets/shop.css">
    <link rel="stylesheet" href="assets/newhome.css">
    <link rel="stylesheet" href="assets/header.css">
</head>

<body>
    <? /*php include ('header.php'*/?>
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
    <div class="top">
        <div class="content">
            <h1>Step into style, Stride with confidence</h1>
            <h3> Your Sole Destination for Trendsetting Footwear!</h3>
            <button onclick="redirectToShopPage()">Explore</button>
        </div>
    </div>
    <!-- <div class="category">
        <div class="title">
            <h1>Category</h1>
        </div>
        <div class="product">
            <div class="card">
                <img src="images/m6.jpg" alt="">
                <p>Fancy</p>

            </div>
            <div class="card">
                <img src="images/s1.png" alt="">
                <p>Casual</p>

            </div>
            <div class="card">
                <img src="images/m4.jpg" alt="">
                <p>Formal</p>

            </div>
        </div>
    </div> -->
    <!-- <div class="popular">
        <div class="title">
            <h1>Popular</h1>
        </div>
        <div class="product1">
            <div class="card">
                <img src="images/m2.jpg" alt="">
                <p>Glittery</p>

            </div>
            <div class="card">
                <img src="images/m5.jpg" alt="">
                <p>Square</p>

            </div>
            <div class="card">
                <img src="images/m7.jpg" alt="">
                <p>Cone</p>

            </div>
        </div>
    </div> -->
    <!-- <div class="new">
        <div class="title">
            <h1>New Products</h1>
        </div>
        <div class="product2">
            <div class="card">
                <img src="images/m8.jpg" alt="">
                <p>Blocks</p>

            </div>
            <div class="card">
                <img src="images/s2.png" alt="">
                <p>Flats</p>

            </div>
            <div class="card">
                <img src="images/m10.jpg" alt="">
                <p>Designer Heels</p>

            </div>
        </div>
    </div> -->

    <section id="product1" style="padding-top:500px" class="section-p">

        <div class="pro-container">
            <?php foreach ($products as $key => $product): ?>
                <div class="pro">
                    <form action="" method="post">
                        <input type='hidden' name='productId' value="<?php echo $product['id']; ?>" />
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

                        <!-- <button type="submit" class="default-btn border-radius-5"> Add to cart
                        </button> -->
                    </form>

                </div>
            <?php endforeach; ?>

        </div>
    </section>
    <div class="foot">
        <?php include('footer.php') ?>
    </div>


</body>

</html>
<script>

    function redirectToShopPage() {

        window.location.href = 'shop.php';
    }
</script>