<?php
session_start();
include('db_connection.php');

// Check if the admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Get the user_id from the query string
$selected_user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : null;

// Redirect back if no user ID is provided
if (!$selected_user_id) {
    echo "<script>alert('No user selected!'); window.location.href = 'manage_accounts.php';</script>";
    exit();
}

// Fetch transactions for the selected user
$query = "
    SELECT i.item_name, t.quantity_added, t.transaction_date 
    FROM transactions t 
    JOIN inventory i ON t.inventory_id = i.inventory_id 
    WHERE t.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $selected_user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transaction History</title>
    <link rel="stylesheet" href="admin.css">
    <style>
        .table-container {
            max-width: 800px;
            margin: auto;
            overflow-x: auto;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ccc;
        }

        th {
            background-color: #002e20;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php include 'partials/header.php'; ?>
    <?php include 'partials/sidebar.php'; ?>
    
    <div class="content" id="content">
        <h1>Transaction History for User ID: <?= htmlspecialchars($selected_user_id); ?></h1>
        <div class="table-container">
            <?php if ($result->num_rows > 0): ?>
                <table border="1">
                    <tr>
                        <th>Item Name</th>
                        <th>Quantity Added</th>
                        <th>Transaction Date</th>
                    </tr>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['item_name']); ?></td>
                            <td><?= htmlspecialchars($row['quantity_added']); ?></td>
                            <td><?= htmlspecialchars($row['transaction_date']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            <?php else: ?>
                <p style="text-align: center;">No transactions found for this user.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>