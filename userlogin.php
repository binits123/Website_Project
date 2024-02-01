<?php
$errorMessage = "";
if ($_POST) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    require('dbconnect.php');
    $sql = "select * from users where email = '$email'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        // Check if a user with the entered email exists
        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);

            // Verify the entered password against the stored hashed password
            if (password_verify($password, $user['password'])) {
                // Password is correct, create a session and redirect to a logged-in page
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['f_name'] . " " . $user['l_name'];
                $_SESSION['email'] = $user['email'];
                header("Location: admindashboard.php"); // Redirect to the dashboard or another logged-in page
                exit();
            } else {
                $errorMessage = "Incorrect email or password";
            }
        } else {
            $errorMessage = "User not found with the entered email";
        }

        mysqli_free_result($result);
    } else {
        $errorMessage = "Incorrect email or password";

    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link rel="stylesheet" href="assets/login.css">
    <link rel="stylesheet" href="assets/header.css">

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
    <section>
        <div class="img">
            <img src="images/pic.JPG">
        </div>
        <div class="content">
            <div class="form">
                <h2>Admin Log In</h2>
                <?php
                if ($errorMessage) {
                    ?>
                    <div class="error">
                        <?php echo $errorMessage; ?>
                    </div>
                    <?php
                }
                ?>
                <form method="post" action="userlogin.php" onsubmit="return validateForm()">
                    <div class="input">
                        <span>E-mail</span>
                        <input type="email" name="email" id="email">
                        <span id="emailError" class="error-message"></span>
                    </div>

                    <div class="input">
                        <span>Password</span>
                        <input type="password" name="password" id="password">
                        <span id="passwordError" class="error-message"></span>
                    </div>

                    <div class="input">
                        <input type="submit" value="LOG IN" name="submit">
                    </div>
                </form>

            </div>
        </div>
    </section>


</body>
<script src="assets/userlogin.js"> </script>

</html>