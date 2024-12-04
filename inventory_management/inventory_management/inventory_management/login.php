<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management Login</title>
    <style>
        body {
            font-family: 'Montserrat', Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        body {
            background-image: url('logo-icons/wave-haikei.svg');
            background-size: cover; /* Covers entire page */
            background-position: center; /* Centers the image */
            background-repeat: no-repeat; /* Prevents image from repeating */
            background-attachment: fixed; /* Keeps image fixed while scrolling */
            transition: background-color 0.4s ease, color 0.4s ease, filter 0.4s ease;
        }

        .login-box {
            background-color: white;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 300px;
        }
        .login-box h2 {
            text-align: center;
        }
        .login-box input[type="text"], .login-box input[type="password"] {
            font-family: 'Montserrat', Arial, sans-serif;
            width: 100%;
            padding: 10px;
            margin: 10px 0px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .login-box input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #002e20;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            box-sizing: border-box;
        }
        .login-box input[type="submit"]:hover {
            background-color: #305a4c;
        }
        .error-message {
            padding-top: 20px;
            color: red;
            text-align: center;
        }

        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 82px;
            background-color: #f4f4f4;
            color: #002e20;
            padding: 0 20px;
            display: flex;
            align-items: center;
            z-index: 1000;
            transition: color 0.4s ease, background-color 0.4s ease;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #002e20;
        }
        
    </style>
</head>
<body>
    <?php include 'partials/header.php'; ?>
    <div class="login-box">
        <h2>Login</h2>
        <form action="login_process.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login">
        </form>
        <?php
            if (isset($_GET['error'])) {
                echo '<div class="error-message">Invalid username or password.</div>';
            }
        ?>
    </div>
</body>
</html>
