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

// Get assigned inventory for the logged-in employee
$user_id = $_SESSION['user_id'];
$sql = "SELECT inventory.item_name, inventory.category, assigned_inventory.initial_quantity, inventory.unit_price
        FROM assigned_inventory
        JOIN inventory ON assigned_inventory.inventory_id = inventory.inventory_id
        WHERE assigned_inventory.user_id = ?";
$stmt = $conn->prepare($sql);
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
    <!-- Add Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>

        /* Keep all other existing styles the same */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #f0f0f0;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
            border-radius: 10px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover, .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .search-box {
            margin: 10px 0;
        }
        
        .dropdown-list {
            max-height: 150px;
            overflow-y: auto;
            border: 1px solid #ccc;
        }

        .dropdown-list li {
            padding: 5px;
            cursor: pointer;
        }

        .dropdown-list li:hover {
            background-color: #D8D9D9;
        }

        .confirm-button {
            font-family: 'Montserrat', Arial, sans-serif;
            background-color: #002e20;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .confirm-button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        .edit-button {
            font-family: 'Montserrat', Arial, sans-serif;
            background-color: #003E39;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }

        .edit-button:hover {
            background-color: #267058;
        }

        .center {
            text-align: center;
        }

        body.dark-mode .edit-button {
            background-color: #d1fff1;
            color: #0F1212;
        }

        body.dark-mode .edit-button:hover {
            background-color: #a5cfc1;
            transition: background-color 0.4s ease, color 0.4s ease;
        }

        body.dark-mode .modal-content {
            background-color: #222;
            color: #ccc;
            transition: background-color 0.4s ease, color 0.4s ease;
        }

        body.dark-mode .close {
            color: #ccc;
            transition: color 0.4s ease;
        }

        body.dark-mode .close:hover, body.dark-mode .close:focus {
            color: #fff;
        }

        body.dark-mode .confirm-button {
            background-color: #d1fff1;
            color: #0F1212;
        }

        body.dark-mode .confirm-button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        body.dark-mode .dropdown-list li:hover {
            background-color: #6A6C6E;
        }

    </style>
</head>
<body>
    <?php include 'partials/header.php'; ?>
    <?php include 'partials/sidebar.php'; ?>
    <div class="content" id="content">
    <h1 style="text-align: center;">Assigned Inventory for <br><?= $_SESSION['username']; ?></h1>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Category</th>
                        <th>Initial Quantity</th>
                        <th>Unit Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['item_name']; ?></td>
                                <td><?= $row['category']; ?></td>
                                <td><?= $row['initial_quantity']; ?></td>
                                <td>Php <?= number_format($row['unit_price'], 2); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3">No assigned inventory found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <!-- Edit Inventory button outside of the table, centered -->
        <div class="center">
            <button class="edit-button" onclick="openModal()">Edit Inventory</button>
        </div>

        <!-- Modal for editing inventory -->
        <div id="editModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h2>Search Product</h2>
                <input type="text" id="searchInput" class="search-box" placeholder="Type product name..." onkeyup="searchProduct()">
                <ul id="productList" class="dropdown-list"></ul>

                <div id="productDetails" style="display:none;">
                    <h3>Product Details</h3>
                    <p>Product ID: <span id="productID"></span></p>
                    <p>Product Name: <span id="productName"></span></p>
                    <p>Category: <span id="productCategory"></span></p>
                    <p>Price: <span id="productPrice"></span></p>
                    <p>Current Quantity: <span id="productQuantity"></span></p>
                    <label for="newQuantity">Enter new amount:</label>
                    <input type="number" id="newQuantity" oninput="enableConfirmButton()">
                    <button id="confirmButton" class="confirm-button" disabled onclick="updateQuantity()">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Open the modal
        function openModal() {
            document.getElementById("editModal").style.display = "block";
        }

        // Close the modal
        function closeModal() {
            document.getElementById("editModal").style.display = "none";
        }

        // Search for products using AJAX
        function searchProduct() {
            var input = document.getElementById("searchInput").value;
            if (input.length > 2) { // Only search if more than 2 characters
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "search_products.php?query=" + input, true);
                xhr.onload = function () {
                    if (this.status === 200) {
                        var products = JSON.parse(this.responseText);
                        var list = document.getElementById("productList");
                        list.innerHTML = "";
                        products.forEach(function(product) {
                            var li = document.createElement("li");
                            li.textContent = product.item_name;
                            li.onclick = function() { displayProductDetails(product); };
                            list.appendChild(li);
                        });
                    }
                }
                xhr.send();
            }
        }

        // Display the product details when selected
        function displayProductDetails(product) {
            document.getElementById("productID").textContent = product.inventory_id;
            document.getElementById("productName").textContent = product.item_name;
            document.getElementById("productCategory").textContent = product.category;
            document.getElementById("productPrice").textContent = product.unit_price;
            document.getElementById("productQuantity").textContent = product.quantity;
            document.getElementById("productDetails").style.display = "block";
        }

        // Enable the confirm button when a new amount is entered
        function enableConfirmButton() {
            var newQuantity = document.getElementById("newQuantity").value;
            document.getElementById("confirmButton").disabled = newQuantity === "";
        }

        // Update the product quantity via AJAX
        function updateQuantity() {
            var productId = document.getElementById("productID").textContent;
            var newQuantity = document.getElementById("newQuantity").value;

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "update_inventory.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onload = function () {
                if (this.status === 200) {
                    var response = JSON.parse(this.responseText);
                    if (response.status === "success") {
                        closeModal(); // Close the modal
                        location.reload(); // Reload the page to see the changes
                    } else {
                        alert("Error updating the inventory. Please try again.");
                    }
                }
            };
            xhr.send("inventory_id=" + productId + "&new_quantity=" + newQuantity);
        }
    </script>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>
