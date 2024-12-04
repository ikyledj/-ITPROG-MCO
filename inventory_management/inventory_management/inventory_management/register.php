<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Account</title>
    <link rel="stylesheet" href="admin.css"> <!-- Ensure your CSS file is linked -->
    <style>
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin: 0 auto; /* Center horizontally */
            width: 300px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            background-color: #ECEFF0;
            font-family: 'Montserrat', Arial, sans-serif; /* Ensure Montserrat font is applied */
            gap: 10px; /* Add spacing between form elements */
        }

        /* Style the input fields */
        input[type="text"], input[type="password"], select {
            font-family: 'Montserrat', Arial, sans-serif;
            font-size: 14px;
            padding: 10px;
            border: 1px solid #ECEFF0;
            border-radius: 5px;
            width: 100%;
            background-color: #fff;
            margin-bottom: 10px; /* Space between inputs */
        }

        /* Style the select dropdown */
        select, option {
            font-family: 'Montserrat', Arial, sans-serif;
            font-size: 14px;
        }

        input[type="submit"] {
            font-family: 'Montserrat', Arial, sans-serif;
            font-size: 14px;
            padding: 10px;
            width: 100%;
            background-color: #175671; /* Primary color */
            color: white; /* Text color */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.4s ease;
        }

        input[type="submit"]:hover {
            background-color: #a6daf2; /* Slightly lighter color for hover */
        }

    </style>
</head>
<body>
    <?php include 'partials/header.php'; ?>
    <?php include 'partials/sidebar.php'; ?>
    <!-- <div class="form-container"> -->
        <div class="content" id="content">
        <h1>Create New Account</h1>
            <div class="input-container">
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
        </div>
    <!-- </div> -->
</body>
</html>