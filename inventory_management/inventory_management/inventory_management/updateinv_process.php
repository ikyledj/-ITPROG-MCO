<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employee') {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventory_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the data from the request
$inventory_id = $_POST['inventory_id'];
$new_quantity = intval($_POST['new_quantity']);
$user_id = $_SESSION['user_id'];

// Get the current quantity of the product
$sql = "SELECT quantity FROM inventory WHERE inventory_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $inventory_id);
$stmt->execute();
$result = $stmt->get_result();
$inventory = $result->fetch_assoc();

$current_quantity = intval($inventory['quantity']);
$quantity_difference = $new_quantity - $current_quantity; // Calculate the difference

// Update the inventory table with the new quantity
$update_sql = "UPDATE inventory SET quantity = ? WHERE inventory_id = ?";
$update_stmt = $conn->prepare($update_sql);
$update_stmt->bind_param("ii", $new_quantity, $inventory_id);
$update_stmt->execute();

// Insert a new transaction record
$insert_transaction_sql = "INSERT INTO transactions (user_id, inventory_id, quantity_added, transaction_date)
                           VALUES (?, ?, ?, NOW())";
$insert_transaction_stmt = $conn->prepare($insert_transaction_sql);
$insert_transaction_stmt->bind_param("iii", $user_id, $inventory_id, $quantity_difference);
$insert_transaction_stmt->execute();

// Return a success response
if ($update_stmt->affected_rows > 0 && $insert_transaction_stmt->affected_rows > 0) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error"]);
}

// Close the prepared statements and database connection
$stmt->close();
$update_stmt->close();
$insert_transaction_stmt->close();
$conn->close();
?>
