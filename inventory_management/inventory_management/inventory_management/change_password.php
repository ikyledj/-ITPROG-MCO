<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$password_error = '';

if (isset($_POST['new_password'], $_POST['confirm_password'])) {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $user_id = $_SESSION['user_id'];

    if ($new_password !== $confirm_password) {
        $password_error = "Passwords do not match.";
    } else {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $query = "UPDATE users SET password = ? WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $hashed_password, $user_id);

        if ($stmt->execute()) {
            $password_error = "Password changed successfully.";
        } else {
            $password_error = "Error updating password.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        $cssFile = isset($_SESSION['role']) && $_SESSION['role'] === 'admin' ? 'admin.css' : 'styles1.css';
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Management</title>
    <link rel="stylesheet" href="<?php echo $cssFile; ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <?php include 'partials/header.php'; ?>
    <?php include 'partials/sidebar.php'; ?>

    <div class="content" id="content">
        <h1 style="text-align: center;">Change Password</h1>
        <div class="input-container">
            <form method="POST">
                <input type="password" name="new_password" placeholder="New Password" required>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                <input type="submit" value="Change Password">
            </form>
        </div>
    </div>

    <!-- Custom Popup -->
    <div class="overlay" id="overlay"></div>
    <div class="popup" id="popup">
        <h2 id="popup-message"></h2>
        <button onclick="closePopup()">Close</button>
    </div>

    <script>
        // Display the popup with the message
        function showPopup(message) {
            document.getElementById('popup-message').textContent = message;
            document.getElementById('popup').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
        }

        // Close the popup
        function closePopup() {
            document.getElementById('popup').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }

        // Get the error or success message from PHP
        let errorMessage = "<?php echo $password_error; ?>";
        
        if (errorMessage) {
            showPopup(errorMessage);
        }
    </script>
</body>
</html>


