<?php

session_start();


if (!isset($_SESSION['customer_id'])) {
    // Redirect to the login page if not logged in
    header("Location: index.php");
    exit();
}

$customerID = $_SESSION['customer_id'];
$customerName = $_SESSION['customer_name'];
?>
<?php
$activeTab = isset($_GET['tab']) ? $_GET['tab'] : 'dash';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-5">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>customerdashboard</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <link rel="stylesheet" href="assets/customerdashboard.css">

<body>
    <div class="grid-container">
        <aside id="sidebar">
            <div class="sidebar-title">
                <div class="sidebar-brand">
                    <span class="material-icons-outlined">account_circle</span>
                    <?php echo $customerName; ?>
                </div>
                <span class="material-icons-outlined" onclick="closeSidebar()">close</span>
            </div>

            <ul class="sidebar-list">
                <li class="sidebar-list-item">
                    <span
                        class="material-icons-outlined <?php echo ($activeTab == 'dash') ? 'active' : ''; ?>">dashboard</span><a
                        class="text-primary" href="?tab=dash"> Dashboard</a>
                </li>

                <li class="sidebar-list-item">
                    <span
                        class="material-icons-outlined <?php echo ($activeTab == 'customer_history') ? 'active' : ''; ?>">history</span><a
                        class="text-primary"
                        href="?tab=customer_history&customer_id=<?php echo $customerID; ?>">History</a>
                </li>

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