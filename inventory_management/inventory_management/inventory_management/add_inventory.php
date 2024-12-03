<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

require 'db_connection.php'; // Database connection

// Fetch User ID from query string
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch form data
    $user_id = intval($_POST['user_id']);
    $item_name = $_POST['item_name'];
    $category = $_POST['category'];
    $unit_price = floatval($_POST['unit_price']);
    $quantity = intval($_POST['quantity']);
    $initial_quantity = intval($_POST['initial_quantity']);

    // Insert new item into inventory table
    $stmt = $conn->prepare("
        INSERT INTO inventory (item_name, category, unit_price, quantity)
        VALUES (?, ?, ?, ?)
    ");
    $stmt->bind_param('ssdi', $item_name, $category, $unit_price, $quantity);
    $stmt->execute();

    // Get the inserted inventory ID
    $inventory_id = $stmt->insert_id;

    // Assign the inventory to the user
    $stmt = $conn->prepare("
        INSERT INTO assigned_inventory (user_id, inventory_id, initial_quantity)
        VALUES (?, ?, ?)
    ");
    $stmt->bind_param('iii', $user_id, $inventory_id, $initial_quantity);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script>alert('Inventory added and assigned successfully!'); window.location.href = 'manage_accounts.php';</script>";
    } else {
        echo "<script>alert('Failed to assign inventory. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Inventory</title>
    <link rel="stylesheet" href="styles1.css">
    <style>
        .form-container {
            max-width: 500px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-container h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .form-container input[type="text"],
        .form-container input[type="number"],
        .form-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-container input[type="submit"] {
            background-color: #002e20;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-container input[type="submit"]:hover {
            background-color: #305a4c;
        }
    </style>
</head>
<body>
    <?php include 'partials/header.php'; ?>
    <?php include 'partials/sidebar.php'; ?>

    <div class="content">
        <div class="form-container">
            <h1>Add Inventory</h1>
            <form method="POST" action="">
                <label for="user_id">User ID:</label>
                <input type="text" id="user_id" name="user_id" value="<?= htmlspecialchars($user_id); ?>" readonly>

                <label for="item_name">Item Name:</label>
                <input type="text" id="item_name" name="item_name" required>

                <label for="category">Category:</label>
                <input type="text" id="category" name="category" required>

                <label for="unit_price">Unit Price:</label>
                <input type="number" id="unit_price" name="unit_price" step="0.01" required>

                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" required>

                <label for="initial_quantity">Initial Quantity:</label>
                <input type="number" id="initial_quantity" name="initial_quantity" required>

                <input type="submit" value="Add Inventory">
            </form>
        </div>
    </div>
</body>
</html>