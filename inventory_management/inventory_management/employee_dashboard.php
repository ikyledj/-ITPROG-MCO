<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employee') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <!-- Add Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .nav-buttons {
            list-style: none;
            padding: 0;
            display: flex;
            gap: 20px;
        }

        .nav-buttons li {
            margin: 0;
        }

        .nav-button {
            display: inline-flex;
            align-items: center;
            padding: 12px 24px;
            background-color: #003E39;
            color: white;
            text-decoration: none;
            border-radius: 25px;
            transition: background-color 0.3s ease;
            gap: 12px; /* Adds consistent spacing between icon and text */
        }

        .nav-button:hover {
            background-color: #267058;
        }

        .nav-button img {
            width: 20px; /* Set consistent width */
            height: 20px; /* Set consistent height */
        }
    </style>
</head>
<body>
    <?php include 'partials/header.php'; ?>
    <?php include 'partials/sidebar.php'; ?>
    <div class="content" id="content">
        <h2 style="text-align: center;">Welcome, <?= $_SESSION['username']; ?></h2>
        
        <nav>
            <ul class="nav-buttons">
                <li>
                    <a href="assigned_inventory.php" class="nav-button">
                        <img src="logo-icons/Package sent rounded.svg" alt="Boxes Icon">
                        View Assigned Inventory
                    </a>
                </li>
                <li>
                    <a href="transaction_history.php" class="nav-button">
                        <img src="logo-icons/Clock 02 Rounded.svg" alt="History Icon">
                        Transaction History
                    </a>
                </li>
            </ul>
        </nav>
        
    </div>

</body>
</html>