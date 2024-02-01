<?php
global $conn;
$error = $success = "";
$sql = "";
function getOrders()
{
    global $conn;
    require('dbconnect.php');
    $sql = "SELECT orders.*, customers.f_name as customer_name FROM orders JOIN customers ON orders.customer_id = customers.id order by created_at desc";
    $result = $conn->query($sql);

    $orders = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
    }

    return $orders;
}
$orders = getOrders();

function getOrder($id)
{
    global $conn;
    require('dbconnect.php');
    $sql = "SELECT * FROM orders WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    return ($result->num_rows > 0) ? $result->fetch_assoc() : null;
}
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
                    <th>S.N</th>
                    <th>Customer</th>
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
                            <?php echo $order['customer_name']; ?>
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
                            
                        <a class="text-primary" href="?tab=ordered_details&order_id=<?php echo $order['id']; ?>" ><button data-id="<?php echo $order['id']; ?>" class="showOrderDetails" >View Order Detail</button></a>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


