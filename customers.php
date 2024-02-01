<?php
global $conn;
$error = $success = "";
$sql = "";
function getCustomers()
{
    global $conn;
    require('dbconnect.php');
    $sql = "SELECT * FROM customers order by id desc";
    $result = $conn->query($sql);

    $customers = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $customers[] = $row;
        }
    }

    return $customers;
}
$customers = getCustomers();


 ?>



<div id="message">
</div>
    
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
<div>
    <div class="main-title">
        <p class="font-weight-bold">Customers</p>

    </div>
    <div class="cards" id="customerList">
        <table>
            <thead>
                <tr>
                    <th>S.N</th>
                    <th>First name</th>
                    <th>Last Name</th>
                    <th>email</th>
                    <th>action</th>

                    
                </tr>
            </thead>
            <tbody>
                
                <?php foreach ($customers as $key => $customer): ?>
                    <tr>
                        <td>
                            <?php echo $key + 1; ?>
                        </td>
                        
                        <td>
                            <?php echo $customer['f_name']; ?>
                        </td>
                        <td>
                            <?php echo $customer['l_name']; ?>
                        </td>
                        <td>
                            <?php echo $customer['email']; ?>
                        </td>
                        <td class="action-buttons">
                                <button onclick="deleteCustomer(<?php echo $customer['id']; ?>)">Delete</button>
                            
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>


</div>

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

    #customerList {
        display: block;
        
    }

    #addEditCustomerForm {
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
    
    function deleteCustomer(customerId) {
        if (confirm('Are you sure you want to delete this customer?')) {
            fetch('Controller/delete_customer_data.php?id=' + customerId)
                .then(response => response.json())
                .then(data => {
            
                    var container = document.getElementById('message');
               
                    //document.getElementById("table-"+customerId).remove();
                    const successMessageDiv = document.createElement('div');
                    
                    
                    console.log(data);
                    if(data == 3){
                        successMessageDiv.classList.add('alert', 'alert-error', 'mt-3');
                        var message = "Customer cannot be deleted";
                    }else{
                        successMessageDiv.classList.add('alert', 'alert-success', 'mt-3');
                        var message ="Customer deleted successfully";
                    }
                    successMessageDiv.role = 'alert';
                    successMessageDiv.style.position = 'relative';
                    successMessageDiv.innerHTML = `
                <span style="margin-right: 10px;">`+message+`</span>
                <button type="button" class="close" aria-label="Close" onclick="closeSuccessMessage(this)">
                    <span aria-hidden="true">&times;</span>
                </button>
            `;

                    
                    container.appendChild(successMessageDiv);
        })
        .catch(error => console.error('Error fetching customer data:', error));

    }
}
    function closeSuccessMessage(button) {
        const successMessageDiv = button.closest('.alert-success');
        if (successMessageDiv) {
            successMessageDiv.remove();
        }
    }
    
</script>