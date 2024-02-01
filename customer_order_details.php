<?php
global $conn;
$error = $success = "";
$sql = "";
$order_id = $_GET['order_id'];
// print_r($_GET['order_id']); die(123);



require('dbconnect.php');
$sql = "SELECT 
    orders.id AS order_id,
    orders.total_price,
    orders.order_date,
    orders.status,
    orders.delivery_date,
    products.name,
    products.image,
    order_products.quantity,
    order_products.price
FROM 
    orders
JOIN 
    order_products ON orders.id = order_products.order_id 
JOIN 
    products ON order_products.product_id = products.id 
WHERE 
    orders.id = $order_id";

$result = mysqli_query($conn, $sql);
$result = $conn->query($sql);

$order = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Append each product to the order array
        $order['order_id'] = $row['order_id'];
        $order['total_price'] = $row['total_price'];
        $order['order_date'] = $row['order_date'];
        $order['status'] = $row['status'];
        $order['delivery_date'] = $row['delivery_date'];


        // Check if the 'products' key is already present in $order
        if (!isset($order['products'])) {
            $order['products'] = [];
        }

        // Append product details to the 'products' array
        $order['products'][] = [
            'image' => $row['image'],
            'product_name' => $row['name'],
            'quantity' => $row['quantity'],
            'price' => $row['price']
        ];

    }

}

?>



<div id="jsonDataContainer">
    <div id="message">  

    </div>
    <a class="text-primary" href="?tab=customer_history" ><button id="close">Close</button></a>
    <p><strong>Order ID:</strong>
        <?php echo $order['order_id']; ?>
    </p>
    <p><strong>Order Date:</strong>
        <?php echo $order['order_date']; ?>
    </p>
    <p><strong>Total Price:</strong>
        <?php echo $order['total_price']; ?>
    </p>
    <p><strong>Order status:</strong>
        <?php echo $order['status'] == 1 ? "Delivered" : "Pending"; ?>
    </p>
    <h2>Products</h2>
    <table class="product-table">
        <tr>
            <th>Image</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Price</th>
        </tr>
        <?php if ($order['products']) {
            foreach ($order['products'] as $product) {
                ?>
                <tr>
                    <td><img width="150px" height="100px" src="images/<?php echo $product['image'];?>"></td>
                    <td><?php echo $product['product_name'];?></td>
                    <td><?php echo $product['quantity'];?></td>
                    <td><?php echo $product['price'];?></td>
                </tr>

            <?php }
        }

        ?>
    </table>
</div>
<div style="margin-bottom:100px"></div>

<style>
    .cards {
        margin-top: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        overflow-x: auto;

    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    .action-buttons form,
    .action-buttons button {
        display: inline;
        padding: 5px 10px;
        margin-right: 5px;
        text-decoration: none;
        color: #fff;
        cursor: pointer;
    }

    #orderList {
        display: block;

    }

    #addEditOrderForm {
        display: none;
        margin-top: 20px;
    }

    select {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 4px;
        cursor: pointer;
        margin-bottom: 20px;
    }


    select:hover {
        border-color: #555;
    }

    select:focus {
        outline: none;
        border-color: #2196F3;
    }
</style>

<script>


function deliverProduct(productId) {
        if (confirm('Are you sure you want to deliver this product?')) {

            fetch('Controller/change_order_status.php?id=' + productId)
                .then(response => response.json())
                .then(data => {
                    location.reload(true);
                })
                .catch(error => console.error('Error fetching product data:', error));
        }
    }

</script>