<?php
session_start();
include('db_connection.php'); // Include database connection

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if user exists
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Store user details in session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
        
            // Redirect based on role
            if ($user['role'] == 'admin') {
                header("Location: admin_dashboard.php");
            } elseif ($user['role'] == 'employee') {
                header("Location: employee_dashboard.php");
            } else {
                // Handle unexpected roles (optional)
                echo "Invalid role assigned to user.";
            }
            exit();
        } else {
            // Redirect back with error for invalid password
            header("Location: login.php?error=1");
            exit();
        }
    } else {
        // Redirect back with error for invalid username
        header("Location: login.php?error=1");
        exit();
    }
} else {
    // Redirect back with error for incomplete form submission
    header("Location: login.php?error=1");
    exit();
}
?>