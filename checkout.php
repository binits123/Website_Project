<?php
global $conn;
session_start();
$cart_count = 0;
require('dbconnect.php');
$status = '';
$signUpFirstName = $signUpLastName = $signUpEmail = $signUpPassword = $signUpConfirmPassword = $signUpAddress = $signUpPhone = $signInEmail = '';
$signUpFirstNameErr = $signUpLastNameErr = $signUpEmailErr = $signUpPasswordErr = $signUpConfirmPasswordErr = $signUpAddressErr = $signUpPhoneErr = '';
$signInEmailErr = $signInPasswordErr = "";
$errorMessage = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['signUpFirstName'])) {
        $signUpFirstName = $_POST['signUpFirstName'];
        $signUpLastName = $_POST['signUpLastName'];
        $signUpEmail = $_POST['signUpEmail'];
        $signUpPassword = $_POST['signUpPassword'];
        $signUpConfirmPassword = $_POST['signUpConfirmPassword'];
        $signUpAddress = $_POST['signUpAddress'];
        $signUpPhone = $_POST['signUpPhone'];
        $signUpFirstNameErr = $signUpLastNameErr = $signUpEmailErr = $signUpAddressErr = $signUpPasswordErr = $signUpConfirmPasswordErr = $signUpPhoneErr = '';
        $error = false;
        if (!$signUpFirstName) {
            $signUpFirstNameErr = "First Name field is required.";
            $error = true;
        }
        if (!$signUpLastName) {
            $signUpLastNameErr = "Last Name field is required.";
            $error = true;
        }

        if (empty($signUpEmail)) {
            $signUpEmailErr = 'Email is required';
        } elseif (!filter_var($signUpEmail, FILTER_VALIDATE_EMAIL)) {
            $signUpEmailErr = 'Invalid email format';
        }

        if (strlen($signUpAddress) < 1) {
            $mobile_error = "Address field is required";
            $error = true;
        }
        if (strlen($signUpPassword) < 1) {
            $mobile_error = "Password field is required";
            $error = true;
        }
        if (strlen($signUpPassword) < 6) {
            $signUpPasswordErr = "Password must be minimum of 6 characters";
            $error = true;
        }
        if ($signUpPassword != $signUpConfirmPassword) {
            $signUpConfirmPasswordErr = "Password and Confirm Password doesn't match";
            $error = true;
        }

        if ($error == false) {
            $hashedPassword = password_hash($signUpPassword, PASSWORD_DEFAULT);

            $sql = "INSERT INTO customers (f_name, l_name, email, password, address, phone)
         VALUES ('$signUpFirstName', '$signUpLastName', '$signUpEmail', '$hashedPassword','$signUpAddress',$signUpPhone)";

            $customerResult = mysqli_query($conn, $sql);

            if ($customerResult) {
                $customerId = mysqli_insert_id($conn);


                unset($_SESSION["shopping_cart_customer"]);

                $_SESSION["shopping_cart_customer"] = array(
                    "customer_id" => $customerId,
                    "customer_name" => $signUpFirstName . " " . $signUpLastName,
                    "customer_email" => $signUpEmail,
                );

                unset($_POST);
                header("Location: payment.php");
                exit();
            }
        } else {

        }
    } else {
        if (empty($_POST["signInEmail"])) {
            $signInEmailErr = "Email is required";
        } else {
            $signInEmail = test_input($_POST["signInEmail"]);
            // Additional email validation if needed
        }

        if (empty($_POST["signInPassword"])) {
            $signInPasswordErr = "Password is required";
        } else {
            $signInPassword = test_input($_POST["signInPassword"]);
            // Additional password validation if needed
        }

        if (empty($signInEmailErr) && empty($signInPasswordErr)) {
            $sql = "select * from customers where email = '$signInEmail'";

            $result = mysqli_query($conn, $sql);

            if ($result) {

                if (mysqli_num_rows($result) > 0) {
                    $customer = mysqli_fetch_assoc($result);

                    // Verify the entered password against the stored hashed password
                    if (password_verify($signInPassword, $customer['password'])) {


                        if ($customer) {
                            $customerId = $customer['id'];
                            unset($_SESSION["shopping_cart_customer"]);

                            $_SESSION["shopping_cart_customer"] = array(
                                "customer_id" => $customerId,
                                "customer_name" => $customer['f_name'] . " " . $customer['l_name'],
                                "customer_email" => $customer['email'],
                            );
                            unset($_POST);
                            header("Location: payment.php");
                            exit();
                        }
                    }
                }
            }
        }
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/shoppingcart.css">
    <link rel="stylesheet" href="assets/header.css">
    <style>
        .error {
            color: red;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            min-height: 100vh;
            justify-content: center;
            align-items: center;
            background-color: #f4f4f4;
        }

        .form-header{
            padding-top: 60px !important;
        }
        .container {
            display: flex;
            width: 850px;
            margint-top: 150px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .left-side,
        .right-side {
            flex: 1;
            padding: 20px;
        }

        .left-side {
            background-color: #fff; /* Change background color as needed */

        }

        .right-side {
            background-color: #fff;
        }

        .form-container {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 8px;
        }

        input {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .action-btn {
            padding: 10px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .cancel-btn {
            padding: 10px;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
    <title>Customer Details</title>
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
</header>
<div class="container">
    <div style="clear:both;"></div>

    <div class="message_box">
        <?php echo $status; ?>
    </div>
    <div class="left-side">
        <div class="shipping">
            <form id="form1" class="form-container" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
               method="post" class="form-container" onsubmit="return validateForm1()" novalidate>
                <h2 class="form-header">Already have an shipping account</h2>
                <label for="email1">Enter your Email address:</label>
                <input type="email" id="signInEmail" class="email" name="signInEmail" >
                <span class="error"> <?php echo $signInEmailErr; ?></span>

                <label for="password1">Enter your Password:</label>
                <input type="password" id="signInPassword" name="signInPassword" class="password" >
                <span class="error"> <?php echo $signInPasswordErr; ?></span>

                <button class="action-btn" style="width: 50%" type="submit" value="signIn">Sign In</button>
                </form>
        </div>
    </div>

    <div class="right-side" novalidate>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="accountForm"
              class="form-container" onsubmit="return validateForm2()">
            <h2 class="form-header">Create new shipping account</h2>
            <label for="firstName">First Name:</label>
            <input type="text" placeholder="First Name" name="signUpFirstName" id="signUpFirstName" class="form2"
                   value="<?php echo htmlspecialchars($signUpFirstName); ?>" >
            <span class="error"><?php echo $signUpFirstNameErr; ?></span>

            <label for="lastName">Last Name:</label>
            <input type="text" placeholder="Last Name" name="signUpLastName" id="signUpLastName" class="form2"
                   value="<?php echo htmlspecialchars($signUpLastName); ?>" >
            <span class="error"><?php echo $signUpLastNameErr; ?></span>

            <label for="email2">Email Address:</label>
            <input type="email" placeholder="Email Address" id="signUpEmail" name="signUpEmail" class="form2"
                   value="<?php echo htmlspecialchars($signUpEmail); ?>" >
            <span class="error"><?php echo $signUpEmailErr; ?></span>

            <label for="password2">Password:</label>
            <input type="password" placeholder="Password" id="signUpPassword" name="signUpPassword" class="form2"
                   >
            <span class="error"><?php echo $signUpPasswordErr; ?></span>

            <label for="confirmPassword">Confirm Password:</label>
            <input type="password" placeholder="Confirm Password" name="signUpConfirmPassword"
                   id="signUpConfirmPassword"  class="form2">
            <span class="error"><?php echo $signUpConfirmPasswordErr; ?></span>

            <label for="address">Address:</label>
            <input type="text" placeholder="Address" id="signUpAddress" name="signUpAddress" class="form2"
                   value="<?php echo htmlspecialchars($signUpAddress); ?>">
            <span class="error"><?php echo $signUpAddressErr; ?></span>

            <label for="phone_number">Phone Number:</label>
            <input type="text" id="signUpPhone" placeholder="Phone Number" name="signUpPhone" class="form2"
                   value="<?php echo htmlspecialchars($signUpPhone); ?>">
            <span class="error"><?php echo $signUpPhoneErr; ?></span>

            <button class="action-btn" style="width: 50%" type="submit" value="signup">Create Account</button>

        </form>
        <a href="shop.php">
            <button class="cancel-button" value="cancel">Cancel</button>
        </a>
    </div>
</div>

</body>
<script src="assets/checkout.js"></script>
</html>
