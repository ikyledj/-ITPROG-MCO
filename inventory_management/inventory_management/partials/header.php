<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Dashboard</title>
    <style>
        /* Header Bar Styles */
        /* header-styles.css */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 82px;
            background-color: #f8f9fa;
            color: white;
            padding: 0 20px;
            display: flex;
            align-items: center;
            z-index: 1000;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #003E39;
        }

        /* Adjust main content area to account for header */
        body {
            padding-top: 70px;
        }
    </style>
</head>
<body>

    <!-- header.php -->
    <link rel="stylesheet" href="header-styles.css">

    <header class="header">
        <h1>Inventory Management System</h1>
    </header>
</body>
</html>
