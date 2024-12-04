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
        /* .table-container {
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
            border: 1px solid #a6daf2;
        }

        th {
            background-color: #417a95;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 15px;
            overflow: hidden;
        }

        table, th, td {
            border: 1px solid #6aa3be;
        }

        th, td {
            padding: 15px;
        }

        th {
            background-color: #0d4159;
            color: white;
            text-align: center;
        }

        td {
            background-color: #f2f2f2;
            color: #0d4159;
            text-align: left;
        }

        .table-container {
            border-radius: 10px;
            padding: 15px;
            margin: 10px auto;
            max-width: 800px;
            background-color: #ECEFF0;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        body.dark-mode table,
        body.dark-mode th,
        body.dark-mode td {
            border-color: #417a95;
            transition: background-color 0.4s ease;
        }

        body.dark-mode th {
            background-color: #a6daf2;
            color: #040506;
            transition: color 0.4s ease, background-color 0.4s ease;
        }

        body.dark-mode td {
            background-color: #0F1212;
            color: #a6daf2;
            transition: color 0.4s ease, background-color 0.4s ease;
        }

        body.dark-mode .table-container {
            background-color: #0F1212; 
            transition: color 0.4s ease, background-color 0.4s ease;
        } */
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