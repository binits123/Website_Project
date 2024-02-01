<?php
global $conn;
$error = $success = "";
$sql = "";
// session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header("Location: index.php");
    exit();
}

function getProducts()
{
    global $conn;
    require('dbconnect.php');
    $sql = "SELECT products.*, category.name as category_name FROM products JOIN category ON products.category_id = category.id order by created_at desc";
    $result = $conn->query($sql);


    $products = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
    return $products;


}

function getCategories()
{
    global $conn;
    require('dbconnect.php');
    $sql = "SELECT * FROM category ";
    $result = $conn->query($sql);
    
    

    $category = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $category[] = $row;
        }
    }
    return $category;
}
$categories=getCategories();

function addUpdateProduct($post)
{
    $name = $post['productName'];
    $id = $post['productId'];

    $description = $post['productDescription'];
    $price = $post['productPrice'];
    $cat = $post['productCategory'];
    $qty = $post['productQuantity'];
    $imageName = '';
    if (isset($_FILES['productImage']) && !empty($_FILES['productImage'])) {
        $uploadDirectory = 'images/products/'; 
        if ($_FILES['productImage']['name']) {
            // Get the details of the uploaded file
            $fileName = basename($_FILES['productImage']['name']);
            $targetPath = $uploadDirectory . $fileName;
            $fileType = pathinfo($targetPath, PATHINFO_EXTENSION);
            // Check if the file is an image
            $isImage = getimagesize($_FILES['productImage']['tmp_name']);
            if ($isImage !== false) {
                // Move the uploaded file to the specified directory
                if (move_uploaded_file($_FILES['productImage']['tmp_name'], $targetPath)) {
                    $imageName = $fileName;
                
                }
            }
        }
    }
    $userID = $_SESSION['user_id'];
    global $conn;
    require('dbconnect.php');
    if ($id && ($id > 0)) {
        $sql = "UPDATE products SET name='$name', price=$price, quantity=$qty,description='$description',admin_id=$userID";
        if ($imageName) {
            $sql .= ", image='$imageName'";
        }
        $sql .= " Where id=$id";

    } else {
        $sql = "INSERT INTO products (name, price,category_id,quantity,image,description,admin_id) VALUES ('$name', $price,$cat,$qty,'$imageName','$description',$userID)";
    }
    
    $result = mysqli_query($conn, $sql);


    return $result;

}

function getProduct($id)
{
    global $conn;
    require('dbconnect.php');
    $sql = "SELECT * FROM products WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    return ($result->num_rows > 0) ? $result->fetch_assoc() : null;
}


?>

<?php

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = '';
    
    if (isset($_POST['add'])) {
        $response = addUpdateProduct($_POST);
    } elseif (isset($_POST['update'])) {
        $response = addUpdateProduct($_POST);
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['delete'];
        deleteProduct($id);
    }
    
    if ($response) {
        

        if ($_POST['productId'] && ($_POST['productId'] > 0)) {
            $success = "Product updated successfully.";

        } else {
            $success = "Product saved successfully.";
        }
    } else {
        $error = "Something went wrong.Please try again.";

    }
    unset($_POST);
    $_POST = [];

}
$products = getProducts();

// print_r($products);die(1111);

?>
<div id="message">

</div>
<?php
if ($error) {
    ?>
    <div class="error">
        <div class="alert alert-error mt-3" role="alert" style="position: relative;">
            <span style="margin-right: 10px;"><?php echo $error; ?></span>
            <button type="button" class="close" aria-label="Close" onclick="closeSuccessMessage(this)">
                <span aria-hidden="true">×</span>
            </button>
        </div>

    </div>
    <?php
}
if ($success) {

    ?>
    <div class="success">

        <div class="alert alert-success mt-3" role="alert" style="position: relative;">
            <span style="margin-right: 10px;"><?php echo $success; ?></span>
            <button type="button" class="close" aria-label="Close" onclick="closeSuccessMessage(this)">
                <span aria-hidden="true">×</span>
            </button>
        </div>

    </div>
    <?php
}
?>
<div>
    <div class="main-title">
        <p class="font-weight-bold" style="margin-top: 0px;">Product</p>
        <button style="text-align: right; height:40px; margin-bottom:0px" onclick="showAddProductForm()">Add Product
        </button>
    </div>
    <div class="cards" id="productList">
        <table>
            <thead>
            <tr>
                <th>S.N</th>
                <th>Image</th>
                <th>Product Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            
            <?php foreach ($products as $key => $product): ?>
                <tr id="table-<?php echo $product['id']; ?>">
                    <td>
                        <?php echo $key + 1; ?>
                    </td>
                    <td>
                        <?php if (!empty($product['image'])): ?>
                            <img src="images/products/<?php echo $product['image']; ?>"
                                 alt="<?php echo $product['name']; ?>" style="max-width: 100px; max-height: 100px;">
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php echo $product['name']; ?>
                    </td>
                    <td>
                        <?php echo $product['category_name']; ?>
                    </td>
                    <td>
                        <?php echo $product['price']; ?>
                    </td>
                    <td class="action-buttons$name">
                        <button onclick="deleteProduct(<?php echo $product['id']; ?>)">Delete</button>
                        <button onclick="showEditProductForm(<?php echo $product['id']; ?>)">Edit</button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>


</div>
<div id="addEditProductForm"  onsubmit="return validateForm()" novalidate >
    <form action="admindashboard.php?tab=products" method="post" id="productForm" enctype="multipart/form-data">
        <label for="productName">Product Name:</label>
        <input type="text" id="productName" name="productName" >

        <label for="productDescription">Product Description:</label>
        <textarea id="productDescription" name="productDescription" rows="4" ></textarea>

        <label for="productPrice">Product Price:</label>
        <input type="number" id="productPrice" name="productPrice" step="0.01" >


        <label for="productCategory">Select a Shoes Category:</label>
        <select id="productCategory" name="productCategory">
        <?php foreach ($categories as $key => $category): ?>
            <option value="<?php echo $category['id']; ?>">
            <?php echo $category['name']; ?>
            </option>
            <?php endforeach; ?>
        </select>

        <label for="productQuantity">Quantity:</label>
        <input type="number" id="productQuantity" name="productQuantity" >

        <div id="appendedImageContainer"></div>
        <label for="productImage">Product Image :</label>
        <input type="file" id="productImage" name="productImage">

        <input type="hidden" id="productId" name="productId">
        <button type="submit" id="submit" name="add" >Save Product</button>
        <button type="button" onclick="cancelAddEdit()">Cancel</button>

    </form>
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
        /* Enable horizontal scrolling on small screens */
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

    #productList {
        display: block;
        
    }

    #addEditProductForm {
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

    mt-3, .my-3 {
        margin-top: 1rem !important;
    }

    alert-success {
        color: #155724;
        background-color: #d4edda;
    !important;
        border-color: #c3e6cb;
    }

    .alert {
        position: relative;
        padding: 0.75rem 1.25rem;
        margin-bottom: 1rem;
        border: 1px solid transparent;
        border-radius: 0.25rem;
    }
</style>

<script>
    function showAddProductForm() {
        document.getElementById("productList").style.display = "none";
        document.getElementById("addEditProductForm").style.display = "block";
        document.getElementById("productId").value = ""; 
        document.getElementById("submit").value = "add"; 
    }

    function fillFormWithData(data) {
        document.getElementById("productList").style.display = "none";
        document.getElementById("addEditProductForm").style.display = "block";

        document.getElementById("productId").value = data.id; 
        document.getElementById("productDescription").value = data.description; 
        document.getElementById("productCategory").value = data.category_id; 
        document.getElementById("productName").value = data.name;
        document.getElementById("productPrice").value = data.price;
        document.getElementById("productQuantity").value = data.quantity;
       
        document.getElementById('submit').name = "update";
        
        var src = "images/products/" + data.image;  

        var container = document.getElementById('appendedImageContainer');
        container.innerHTML += '<img style="height:100px; widht:150px;" src="' + src + '" alt="' + data.name + '">';
    }

    function showEditProductForm(productId) {
        fetch('Controller/get_product_data.php?id=' + productId)
            .then(response => response.json())
            .then(data => fillFormWithData(data))
            .catch(error => console.error('Error fetching product data:', error));
    }

    function cancelAddEdit() {
        document.getElementById("productList").style.display = "block";
        document.getElementById("addEditProductForm").style.display = "none";
    }

    function deleteProduct(productId) {
        if (confirm('Are you sure you want to delete this product?')) {

            fetch('Controller/delete_product_data.php?id=' + productId)
                .then(response => response.json())
                .then(data => {
                    // Handle the success case with the parsed JSON data

                    var container = document.getElementById('message');
                
                    document.getElementById("table-" + productId).remove();
                    const successMessageDiv = document.createElement('div');
                    successMessageDiv.classList.add('alert', 'alert-success', 'mt-3');
                    successMessageDiv.role = 'alert';
                    successMessageDiv.style.position = 'relative';
                    
                    if(data == 3){
                        var message = "Product cannot be deleted";
                    }else{
                        var message ="product deleted successfully";
                    }
                    
                    successMessageDiv.innerHTML = `
                <span style="margin-right: 10px;">`+message+`</span>
                <button type="button" class="close" aria-label="Close" onclick="closeSuccessMessage(this)">
                    <span aria-hidden="true">&times;</span>
                </button>
            `;

                   
                    container.appendChild(successMessageDiv);
                })
                .catch(error => console.error('Error fetching product data:', error));
        }
    }

        function closeSuccessMessage(button) {
            const successMessageDiv = button.closest('.alert-success');
            if (successMessageDiv) {
                successMessageDiv.remove();
            }
        }
</script>
<script src="assets/products.js"></script>