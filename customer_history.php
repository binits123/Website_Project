<?php
global $conn;
$error = $success = "";
$sql = "";
$customer_id=$_SESSION['customer_id'];
function getOrdersByCustomerId($customer_id)
{
    global $conn;
    require('dbconnect.php');
    $sql = "SELECT orders.*, customers.f_name as customer_name FROM orders JOIN customers ON orders.customer_id = customers.id WHERE orders.customer_id=$customer_id order by created_at desc";
    $result = $conn->query($sql);

    $orders = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
    }

    return $orders;
}
$orders = getOrdersByCustomerId($customer_id);


?>


<div id="message">
    <?php
    if ($error) {
        ?>
        <div class="error">
            <?php echo $error; ?>
        </div>
        <?php
    }
    if ($success) {
        ?>
        <div class="success">
            <?php echo $success ?>
        </div>
        <?php
    }
    ?>
</div>
<div>
    <div class="main-title">
        <p class="font-weight-bold">Order</p>

    </div>
    <div class="cards" id="orderList">
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Payment Method</th>
                    <th>Total Price</th>
                    <th>Ordered date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($orders as $key => $order): ?>
                    <tr id="table-<?php echo $order['id']; ?>">
                        <td>
                            <?php echo $key + 1; ?>
                        </td>
                        <td>
                            <?php echo $order['payment_method']; ?>
                        </td>
                        <td>
                            <?php echo $order['total_price']; ?>
                        </td>
                        <td>
                            <?php echo $order['order_date']; ?>
                        </td>
                        <td>
                            <?php echo $order['status']==1?"Delivered":"Pending"; ?>
                        </td>
                        <td class="action-buttons">
                            
                        <a class="text-primary" href="?tab=customer_order_details&order_id=<?php echo $order['id']; ?>" ><button data-id="<?php echo $order['id']; ?>" class="showOrderDetails" >View Order Detail</button></a>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


