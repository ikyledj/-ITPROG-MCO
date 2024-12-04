<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

require 'db_connection.php'; // Database connection

// Fetch all employees
$employees_result = $conn->query("SELECT user_id, username FROM users WHERE role = 'employee'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Accounts</title>
    <link rel="stylesheet" href="admin.css">
    <style>
        .employee-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            padding: 20px;
        }

        .employee-card {
            background-color: #f4f4f4;
            padding: 20px;
            width: 200px;
            text-align: center;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
        }

        .employee-card:hover {
            transform: translateY(-10px) scale(1.05);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            background-color: #e0e0e0;
        }   

        .employee-card h3 {
            margin: 0;
            font-size: 1.2em;
        }

        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #f4f4f4;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }

        .modal.active {
            display: block;
        }

        .modal .options {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .modal .options a {
            display: block;
            text-decoration: none;
            color: white;
            background-color: #175671;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
        }

        .modal .options a:hover {
            background-color: #6aa3be;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .overlay.active {
            display: block;
        }

        body.dark-mode .employee-card {
            background-color: #0F1212;
            transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.4s ease;
        }

        body.dark-mode .employee-card:hover {
            background-color: #333;
        }

        body.dark-mode .modal {
            background-color: #0F1212;
        }

        body.dark-mode .modal .options a {
            color: #0F1212;
            background-color: #a6daf2;
        }

        body.dark-mode .modal .options a:hover {
            background-color: #417a95;
        }

    </style>
</head>
<body>
    <?php include 'partials/header.php'; ?>
    <?php include 'partials/sidebar.php'; ?>

    <div class="content">
        <h1 style="text-align: center;">Manage Accounts</h1>
        <div class="employee-container">
            <?php while ($employee = $employees_result->fetch_assoc()): ?>
                <div class="employee-card" data-user-id="<?= $employee['user_id']; ?>" data-username="<?= $employee['username']; ?>">
                    <h3><?= $employee['username']; ?></h3>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <div class="overlay"></div>
    <div class="modal">
        <h2 style="text-align: center;" id="employee-name"></h2>
        <div class="options">
            <a href="#" id="add-inventory">Add Inventory</a>
            <a href="#" id="check-transactions">Check Transactions</a>
            <a href="#" id="export-history">Export Transaction History</a>
        </div>
    </div>

    <script>
        const employeeCards = document.querySelectorAll('.employee-card');
        const modal = document.querySelector('.modal');
        const overlay = document.querySelector('.overlay');
        const employeeName = document.getElementById('employee-name');
        const addInventory = document.getElementById('add-inventory');
        const checkTransactions = document.getElementById('check-transactions');
        const exportHistory = document.getElementById('export-history');

        employeeCards.forEach(card => {
            card.addEventListener('click', () => {
                const userId = card.getAttribute('data-user-id');
                const username = card.getAttribute('data-username');
                
                // Set employee name in modal
                employeeName.textContent = username;

                // Set hrefs for actions
                addInventory.href = `add_inventory.php?user_id=${userId}`;
                checkTransactions.href = `check_transactions.php?user_id=${userId}`;
                exportHistory.href = `export_transactions.php?user_id=${userId}`;

                // Show modal and overlay
                modal.classList.add('active');
                overlay.classList.add('active');
            });
        });

        overlay.addEventListener('click', () => {
            modal.classList.remove('active');
            overlay.classList.remove('active');
        });
    </script>
</body>
</html>