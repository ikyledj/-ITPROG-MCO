<?php
session_start();
include('db_connection.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT i.item_name, t.quantity_added, t.transaction_date 
          FROM transactions t 
          JOIN inventory i ON t.inventory_id = i.inventory_id 
          WHERE t.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transaction History</title>
    <link rel="stylesheet" href="styles1.css">
    <style>
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 15px;
            overflow: hidden;
        }
        
        table, th, td {
            border: 1px solid black;
        }
        
        th, td {
            padding: 10px;
            text-align: left;
        }
        
        th {
            background-color: #003E39;
            color: white;
        }
        
        td {
            background-color: #f2f2f2;
            color: black;
        }
    </style>
</head>
<body>
    <?php include 'partials/header.php'; ?>
    <?php include 'partials/sidebar.php'; ?>
    <div class="content" id="content">
        <h2 style="text-align: center;">Transaction History</h2>
        <table border="1">
            <tr>
                <th>Item Name</th>
                <th>Quantity Added</th>
                <th>Transaction Date</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['item_name']; ?></td>
                    <td><?= $row['quantity_added']; ?></td>
                    <td><?= $row['transaction_date']; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
