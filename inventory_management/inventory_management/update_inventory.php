<form action="update_inventory.php" method="POST">
    <input type="number" name="new_quantity" placeholder="New Quantity" required>
    <input type="hidden" name="inventory_id" value="<?= $inventory_id ?>">
    <button type="submit">Update</button>
</form>
<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['inventory_id']) && isset($_POST['new_quantity'])) {
    $inventory_id = $_POST['inventory_id'];
    $new_quantity = $_POST['new_quantity'];
    $user_id = $_SESSION['user_id'];

    // Update quantity in the assigned inventory
    $query = "UPDATE assigned_inventory SET initial_quantity = ? WHERE inventory_id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iii", $new_quantity, $inventory_id, $user_id);

    if ($stmt->execute()) {
        // Log the transaction
        $log_query = "INSERT INTO transactions (user_id, inventory_id, quantity_added) VALUES (?, ?, ?)";
        $log_stmt = $conn->prepare($log_query);
        $log_stmt->bind_param("iii", $user_id, $inventory_id, $new_quantity);
        $log_stmt->execute();

        header("Location: assigned_inventory.php");
        exit();
    } else {
        echo "Error updating inventory.";
    }
}
?>
