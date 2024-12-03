<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

require 'db_connection.php'; // Connection to inventory_management database

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $user_id = intval($_POST['user_id']);

    // Fetch transactions for the selected user
    $stmt = $conn->prepare("
        SELECT t.transaction_id, u.username, i.item_name, t.quantity_added, t.transaction_date 
        FROM transactions t
        INNER JOIN users u ON t.user_id = u.user_id
        INNER JOIN inventory i ON t.inventory_id = i.inventory_id
        WHERE t.user_id = ?
    ");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Generate XML
        $xml = new DOMDocument('1.0', 'UTF-8');
        $xml->formatOutput = true;

        $root = $xml->createElement('transactions');
        $xml->appendChild($root);

        while ($row = $result->fetch_assoc()) {
            $transaction = $xml->createElement('transaction');

            $transaction->appendChild($xml->createElement('transaction_id', $row['transaction_id']));
            $transaction->appendChild($xml->createElement('username', $row['username']));
            $transaction->appendChild($xml->createElement('item_name', $row['item_name']));
            $transaction->appendChild($xml->createElement('quantity_added', $row['quantity_added']));
            $transaction->appendChild($xml->createElement('transaction_date', $row['transaction_date']));

            $root->appendChild($transaction);
        }

        // Output the XML file for download
        header('Content-Type: application/xml');
        header('Content-Disposition: attachment; filename="transactions_user_' . $user_id . '.xml"');
        echo $xml->saveXML();
        exit();
    } else {
        echo "No transactions found for the selected user.";
    }
} else {
    // Fetch all users to populate the dropdown
    $users_result = $conn->query("SELECT user_id, username FROM users WHERE role = 'employee'");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Export Transactions</title>
    <link rel="stylesheet" href="styles1.css">
    <style>
        form {
        display: flex;
        flex-direction: column;
        justify-content: center; /* Center content vertically */
        margin: 0 auto; /* Center the form horizontally within its container */
        width: 300px;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        background-color: #ECEFF0;
        font-family: 'Montserrat', Arial, sans-serif; /* Ensure Montserrat font is applied */
        gap: 10px; /* Add space between elements */
    }

    /* Style the select dropdown */
    select, option {
        font-family: 'Montserrat', Arial, sans-serif;
        font-size: 14px;
        padding: 10px;
        border: 1px solid #ECEFF0;
        border-radius: 5px;
        width: 100%;
        background-color: #fff; /* Match form background */
    }

    /* Style the button to match other buttons */
    button {
        font-family: 'Montserrat', Arial, sans-serif;
        font-size: 14px;
        padding: 10px;
        width: 100%;
        background-color: #002e20; /* Primary color */
        color: white; /* Text color */
        border: none; /* No border */
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.4s ease;
    }

    /* Add hover effect for the button */
    button:hover {
        background-color: #305a4c; /* Slightly lighter color for hover */
    }

    body.dark-mode button {
        background-color: #d1fff1;
        color: #040506;
        transition: color 0.4s ease, background-color 0.4s ease;
    }

    body.dark-mode button:hover {
        background-color: #a5cfc1; /* Slightly lighter color for hover */
        transition: color 0.4s ease, background-color 0.4s ease;
    }

    </style>
</head>
<body>
    <?php include 'partials/header.php'; ?>
    <?php include 'partials/sidebar.php'; ?>

    <div class="content">
        <h1>Export Transactions by User</h1>
        <form method="POST" action="">
            <label for="user_id">Select User:</label>
            <select name="user_id" id="user_id" required>
                <option value="">-- Select Employee --</option>
                <?php while ($user = $users_result->fetch_assoc()): ?>
                    <option value="<?= $user['user_id']; ?>"><?= $user['username']; ?></option>
                <?php endwhile; ?>
            </select>
            <button type="submit">Export to XML</button>
        </form>
    </div>
</body>
</html>