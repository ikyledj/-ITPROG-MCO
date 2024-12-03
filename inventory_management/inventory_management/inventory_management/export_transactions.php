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

// Check if transactions exist
if ($result->num_rows > 0) {
    // Initialize XML document
    $xml = new DOMDocument('1.0', 'UTF-8');
    $xml->formatOutput = true;

    // Root element
    $root = $xml->createElement('Transactions');
    $xml->appendChild($root);

    // Add each transaction to the XML
    while ($row = $result->fetch_assoc()) {
        $transaction = $xml->createElement('Transaction');

        $item_name = $xml->createElement('ItemName', htmlspecialchars($row['item_name']));
        $quantity_added = $xml->createElement('QuantityAdded', htmlspecialchars($row['quantity_added']));
        $transaction_date = $xml->createElement('TransactionDate', htmlspecialchars($row['transaction_date']));

        $transaction->appendChild($item_name);
        $transaction->appendChild($quantity_added);
        $transaction->appendChild($transaction_date);

        $root->appendChild($transaction);
    }

    // Set headers for XML download
    header('Content-Type: application/xml');
    header('Content-Disposition: attachment; filename="transaction_history_user_' . $selected_user_id . '.xml"');

    // Output XML content
    echo $xml->saveXML();
    exit();
} else {
    echo "<script>alert('No transactions found for the selected user!'); window.location.href = 'manage_accounts.php';</script>";
    exit();
}
?>