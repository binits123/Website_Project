<?php
global $conn;
$error = $success = "";
$sql = "";
function getCategory()
{
    global $conn;
    require('dbconnect.php');
    $sql = "SELECT * FROM category order by id DESC ";
    $result = $conn->query($sql);

    $category = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $category[] = $row;
        }
    }

    return $category;
}

function addCategory($post)
{
    $f_name = $post['f_name'];
    $l_name = $post['l_name'];
    $email = $post['email'];
    $confirmpassword = $post['confirmPassword'];

    $password = $post['password'];
    if ($password == $confirmpassword) {
        $error = 'Password and Confirm password does not match';
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        require('dbconnect.php');
        $sql = "INSERT INTO category (f_name, l_name, email, password)
         VALUES ('$f_name', '$l_name', '$email', '$hashedPassword')";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            unset($_POST);
            $success = "Category saved successfully.";
        } else {
            $error = "Something went wrong.Please try again.";
        }
        return $result;

    }

}

function getOneCategory($id)
{
    global $conn;
    require('dbconnect.php');
    $sql = "SELECT * FROM category WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    return ($result->num_rows > 0) ? $result->fetch_assoc() : null;
}

function updateCategory($id, $name, $price)
{
    global $conn;
    require('dbconnect.php');
    $sql = "UPDATE category SET name='$name', price=$price WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    return $result;
}

function deleteCategory($id)
{
    global $conn;
    require('dbconnect.php');
    $sql = "DELETE FROM category WHERE id=$id";
    return mysqli_query($conn, $sql);

}

?>

<?php

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        addCategory($_POST);
    } elseif (isset($_POST['update'])) {

        updateCategory($_POST);
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['delete'];
        deleteCategory($id);
    }
}
$category = getCategory();
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
        <p class="font-weight-bold">Category</p>
        <button style="text-align: right; height:40px; margin-bottom:0px" id="addCategory" onclick="showAddCategoryForm()">Add
            Category
        </button>
    </div>
    <div class="cards" id="categoryList">
        <table>
            <thead>
            <tr>
                <th>S.N</th>
                <th>Name</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            
            <?php foreach ($category as $key => $categories): ?>
                <tr id="table-<?php echo $categories['id'];?>">
                    <td>
                        <?php echo $key + 1; ?>
                    </td>

                    <td>
                        <?php echo $categories['name']; ?>
                    </td>
                    <td>
                        <?php echo $categories['description']; ?>
                    </td>
                   
                    <td class="action-buttons">
                        <button onclick="deleteCategory(<?php echo $categories['id']; ?>)">Delete</button>
                        <button onclick="showEditCategoryForm(<?php echo $categories['id']; ?>)">Edit</button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>


</div>
<div id="addEditCategoryForm">
    <form id="categoryForm" enctype="multipart/form-data" onsubmit="return validateForm()">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="description">Description:</label>
        <input type="text" id="description" name="description" rows="4" required>

        <input type="hidden" id="categoryId" name="categoryId">
        <button type="button" onclick="submitForm()" name="add">Save Category</button>
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

    #categoryList {
        display: block;
        /* Display the category list by default */
    }

    #addEditCategoryForm {
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
    function submitForm() {
        var formData = new FormData(document.getElementById('categoryForm'));
        fetch("Controller/add_edit_category_data.php", {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                // Handle the success case with the parsed JSON data
                var alerttext = data.success ? "success" : "error";
                var container = document.getElementById('message');
                const successMessageDiv = document.createElement('div');
                successMessageDiv.classList.add('alert', 'alert-' + alerttext, 'mt-3');
                successMessageDiv.role = 'alert';
                successMessageDiv.style.position = 'relative';

                // Add the success message and close button with inline styles
                successMessageDiv.innerHTML = `
            <span style="margin-right: 10px;">${data.message}</span>
            <button type="button" class='close' aria-label="Close" onclick="closeSuccessMessage(this)">
                <span aria-hidden="true">&times;</span>
            </button>
        `;
                if (container && container.innerHTML.trim() !== '') {
                    container.innerHTML = '';
                }
                container.appendChild(successMessageDiv);
                setTimeout(function () {
                    container.innerHTML = '';
                    if (data.success == true) {
                        location.reload();
                    }
                }, 5000);
                if (data.success == true) {

                    document.getElementById("categoryList").style.display = "block";
                    document.getElementById("addEditCategoryForm").style.display = "none";
                    document.getElementById("categoryId").value = ""; // Clear any previous category ID
                }

                

            })
            .catch(error => {
                console.error("Error:", error);
            })
    }

    function showAddCategoryForm() {
        document.getElementById('categoryForm').reset();
        document.getElementById("categoryList").style.display = "none";
        document.getElementById("addEditCategoryForm").style.display = "block";
        document.getElementById("categoryId").value = ""; // Clear any previous category ID
        document.getElementById('password').style.display = 'block';
        document.getElementById('confirmPassword').style.display = 'block';
        document.getElementById('password').previousElementSibling.style.display = 'block';
        document.getElementById('confirmPassword').previousElementSibling.style.display = 'block';

    }

    function fillFormWithData(data) {
        document.getElementById("categoryList").style.display = "none";
        document.getElementById("addEditCategoryForm").style.display = "block";

        document.getElementById("categoryId").value = data.id; // Set the category ID for editing
        document.getElementById("name").value = data.name; // Set the category ID for editing
        document.getElementById("description").value = data.description; // Set the category ID for editing
        document.getElementById("email").value = data.email;
        document.getElementById("email").value = data.email;
        var readOnlyPassword = document.getElementById('password');
        var readOnlyConfirmPassword = document.getElementById('confirmPassword');

        // Hide the elements
        if (readOnlyPassword && readOnlyConfirmPassword) {
            readOnlyPassword.style.display = 'none';
            var passwordlabel = readOnlyPassword.previousElementSibling;
            if (passwordlabel) {
                passwordlabel.style.display = 'none';
            }
            readOnlyConfirmPassword.style.display = 'none';
            var confirmPasswordLabel = readOnlyConfirmPassword.previousElementSibling;
            if (confirmPasswordLabel) {
                confirmPasswordLabel.style.display = 'none';
            }
        }
        
        document.getElementById('submit').name = "update";
        
    }

    function showEditCategoryForm(categoryId) {

        fetch('Controller/get_category_data.php?id=' + categoryId)
            .then(response => response.json())
            .then(data => fillFormWithData(data))
            .catch(error => console.error('Error fetching category data:', error));
    }

    function cancelAddEdit() {
        document.getElementById("categoryList").style.display = "block";
        document.getElementById("addEditCategoryForm").style.display = "none";
    }

    function deleteCategory(categoryId) {
        if (confirm('Are you sure you want to delete this category?')) {
            fetch('Controller/delete_category_data.php?id=' + categoryId)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    // Handle the success case with the parsed JSON data
                    var alerttext = data.success ? "success" : "error";
                    var container = document.getElementById('message');
                    const successMessageDiv = document.createElement('div');
                    successMessageDiv.classList.add('alert', 'alert-' + alerttext, 'mt-3');
                    successMessageDiv.role = 'alert';
                    successMessageDiv.style.position = 'relative';

                    // Add the success message and close button with inline styles
                    successMessageDiv.innerHTML = `
            <span style="margin-right: 10px;">${data.message}</span>
            <button type="button" class='close' aria-label="Close" onclick="closeSuccessMessage(this)">
                <span aria-hidden="true">&times;</span>
            </button>
        `;
                    if (container && container.innerHTML.trim() !== '') {
                        container.innerHTML = '';
                    }
                    container.appendChild(successMessageDiv);
                    setTimeout(function () {
                        container.innerHTML = '';
                        location.reload()
                    }, 5000);

                })
                .catch(error => console.error('Error fetching category data:', error));
        }
    }

    function closeSuccessMessage(button) {
        const successMessageDiv = button.closest('.alert');
        if (successMessageDiv) {
            successMessageDiv.remove();
        }
    }
</script>
<script src="assets/catagory.php"></script>