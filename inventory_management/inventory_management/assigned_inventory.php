<?php
session_start();
include('db_connection.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT i.item_name, i.category, ai.initial_quantity, i.unit_price 
          FROM assigned_inventory ai 
          JOIN inventory i ON ai.inventory_id = i.inventory_id 
          WHERE ai.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Assigned Inventory</title>
    <link rel="stylesheet" href="styles1.css">
</head>
<body>
    <?php include 'partials/header.php'; ?>
    <?php include 'partials/sidebar.php'; ?>
    <div class="content" id="content">
        <h2>Assigned Inventory</h2>
        <table border="1">
            <tr>
                <th>Item Name</th>
                <th>Category</th>
                <th>Quantity</th>
                <th>Unit Price</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['item_name']; ?></td>
                    <td><?= $row['category']; ?></td>
                    <td><?= $row['initial_quantity']; ?></td>
                    <td><?= $row['unit_price']; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
    
</body>
</html>
