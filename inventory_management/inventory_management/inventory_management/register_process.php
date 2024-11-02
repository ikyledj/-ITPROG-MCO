<?php
include('db_connection.php'); // Include database connection

if (isset($_POST['username'], $_POST['password'], $_POST['confirm_password'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        header("Location: register.php?error=Passwords do not match");
        exit();
    }

    // Check if username already exists
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        header("Location: register.php?error=Username already exists");
        exit();
    }

    // Hash the password and insert new user with default 'employee' role
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $role = 'employee'; // Default role

    $insert_query = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_query);
    $insert_stmt->bind_param("sss", $username, $hashed_password, $role);

    if ($insert_stmt->execute()) {
        header("Location: login.php");
        exit();
    } else {
        header("Location: register.php?error=Failed to create account");
        exit();
    }
} else {
    header("Location: register.php?error=Invalid input");
    exit();
}
?>
