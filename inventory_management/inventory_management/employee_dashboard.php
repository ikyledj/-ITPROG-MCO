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
</head>
<body>
    <h2>Welcome, <?= $_SESSION['username']; ?></h2>

    <nav>
        <ul>
            <li><a href="assigned_inventory.php">View Assigned Inventory</a></li>
            <li><a href="transaction_history.php">Transaction History</a></li>
        </ul>
    </nav>

    <a href="logout.php">Logout</a>
</body>
</html>
