<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Welcome, Admin <?= $_SESSION['username']; ?></h2>
    
    <nav>
        <ul>
            <li><a href="manage_users.php">Manage Users</a></li>
            <li><a href="assign_inventory.php">Assign Inventory</a></li>
            <li><a href="view_reports.php">View Reports</a></li>
        </ul>
    </nav>

    <a href="logout.php">Logout</a>
</body>
</html>
