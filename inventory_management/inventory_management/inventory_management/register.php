<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Account</title>
    <link rel="stylesheet" href="styles1.css"> <!-- Ensure your CSS file is linked -->
</head>
<body>
    <div class="form-container">
        <h2>Create New Account</h2>

        <?php
        // Database connection details
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "inventory_management"; // Replace with your actual database name

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("<p>Connection failed: " . $conn->connect_error . "</p>");
        }

        // Process form data if submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $conn->real_escape_string($_POST["username"]);
            $password = $_POST["password"];
            $confirm_password = $_POST["confirm_password"];
            $role = $conn->real_escape_string($_POST["role"]);

            // Validate passwords
            if ($password !== $confirm_password) {
                echo "<div class='error-message'>Passwords do not match.</div>";
            } else {
                // Hash the password
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                // Prepare and execute the SQL statement
                $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss", $username, $hashed_password, $role);

                if ($stmt->execute()) {
                    echo "<div class='success-message'>Account created successfully!</div>";
                } else {
                    echo "<div class='error-message'>Error: " . htmlspecialchars($stmt->error) . "</div>";
                }

                // Close the statement
                $stmt->close();
            }
        }

        // Close the connection
        $conn->close();
        ?>

        <form action="" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            
            <label for="role">Select Role:</label>
            <select id="role" name="role" required>
                <option value="admin">Admin</option>
                <option value="employee">Employee</option>
            </select>
            
            <input type="submit" value="Register">
        </form>
    </div>
</body>
</html>