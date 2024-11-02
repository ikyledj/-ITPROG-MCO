<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventory_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $item_name = $_POST['item_name'];
    $category = $_POST['category'];
    $unit_price = $_POST['unit_price'];
    $quantity = $_POST['quantity'];
    $initial_quantity = $_POST['initial_quantity'];

    // Validate user ID
    $user_check_query = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($user_check_query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user_result = $stmt->get_result();

    if ($user_result->num_rows == 0) {
        echo "Invalid User ID!";
    } else {
        // Insert into inventory table
        $inventory_insert_query = "INSERT INTO inventory (item_name, category, unit_price, quantity) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($inventory_insert_query);
        $stmt->bind_param("ssdi", $item_name, $category, $unit_price, $quantity);
        $stmt->execute();
        $inventory_id = $conn->insert_id;  // Get the last inserted inventory_id

        // Insert into assigned_inventory table with auto-increment assign_id
        $assign_insert_query = "INSERT INTO assigned_inventory (user_id, inventory_id, initial_quantity) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($assign_insert_query);
        $stmt->bind_param("iii", $user_id, $inventory_id, $initial_quantity);
        $stmt->execute();

        echo "Item successfully added!";
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Inventory</title>
</head>
<body>
    <h1>Add New Product</h1>
    <form method="POST" action="">
        User ID: <input type="number" name="user_id" required><br>
        Item Name: <input type="text" name="item_name" required><br>
        Category: <input type="text" name="category" required><br>
        Unit Price: <input type="number" step="0.01" name="unit_price" required><br>
        Quantity: <input type="number" name="quantity" required><br>
        Initial Quantity: <input type="number" name="initial_quantity" required><br>
        <input type="submit" value="Add Product">
    </form>
</body>
</html>
