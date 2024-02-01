<?php

session_start();


if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header("Location: userlogin.php");
    exit();
}

$userID = $_SESSION['user_id'];
$userName = $_SESSION['user_name'];
?>
<?php
$activeTab = isset($_GET['tab']) ? $_GET['tab'] : 'dashboards';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-5">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>admindashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    <link rel="stylesheet" href="assets/admin.css">
    <style>


    </style>

</head>

<body>
    <div class="grid-container">
        <header class="header">

        </header>

        <aside id="sidebar">
            <div class="sidebar-title">
                <div class="sidebar-brand">
                    <span class="material-icons-outlined">account_circle</span>
                    <?php echo $userName; ?>
                </div>
                <span class="material-icons-outlined" onclick="closeSidebar()">close</span>
            </div>
            <ul class="sidebar-list tab">
                <li class="sidebar-list-item tablinks <?php echo ($activeTab == 'dashboards') ? 'active' : ''; ?>"><a
                        class="text-primary" href="?tab=dashboards"><span
                            class="material-icons-outlined ">dashboard</span> Dashboard</a></li>
                <li class="sidebar-list-item tablinks <?php echo ($activeTab == 'categories') ? 'active' : ''; ?>"><a
                        class="text-primary" href="?tab=categories"><span
                            class="material-icons-outlined">category</span> Category</a></li>
                <li class="sidebar-list-item tablinks <?php echo ($activeTab == 'products') ? 'active' : ''; ?>"><a
                        class="text-primary" href="?tab=products"><span
                            class="material-icons-outlined">inventory_2</span> Products</a></li>
                <li class="sidebar-list-item tablinks <?php echo ($activeTab == 'customers') ? 'active' : ''; ?>"><a
                        class="text-primary" href="?tab=customers"><span
                            class="material-icons-outlined">group</span> Customer</a></li>

                <li class="sidebar-list-item tablinks <?php echo ($activeTab == 'admins') ? 'active' : ''; ?>"><a
                        class="text-primary" href="?tab=admins"><span
                            class="material-icons-outlined">person_add</span> Admins</a></li>

                <li class="sidebar-list-item tablinks <?php echo ($activeTab == 'purchaseOrder') ? 'active' : ''; ?>"><a
                        class="text-primary" href="?tab=purchaseOrder"><span
                            class="material-icons-outlined">add_shopping_cart</span> Purchase Orders
                    </a></li>
            </ul>
            <div class="logout">
                <li class="sidebar-list-item">
                    <a href="logout.php">
                    Log Out
                    </a>
                </li>
            </div>
        </aside>

        <main class="main-container">
            <?php
            // Include the content based on the active tab
            $tabContentFile = $activeTab . '.php';

            if (file_exists($tabContentFile)) {
                include($tabContentFile);
            } else {
                echo 'File not found for tab: ' . $activeTab;
            }
            ?>

            <script src="assets/admin.js"></script>
    </div>

</body>

</html>