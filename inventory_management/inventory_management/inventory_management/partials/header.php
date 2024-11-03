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
            background-color: #ffffff;
            color: white;
            padding: 0 20px;
            display: flex;
            align-items: center;
            z-index: 1000;
            transition: background-color 0.4s ease, color 0.4s ease;
        }

        body.dark-mode {
            background-color: #121212;
            color: #ffffff;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #003E39;
        }

        body.dark-mode .header {
            background-color: #121212;
            color: #ffffff;
        }

        body.dark-mode .header h1 {
            color: white;
        }

        /* Adjust main content area to account for header */
        body {
            padding-top: 70px;
        }
    </style>
</head>
<body>

    <header class="header">
        <h1>Inventory Management System</h1>
    </header>

    <script>
    // On page load, check if dark mode is saved in local storage
    window.onload = function() {
        if (localStorage.getItem('dark-mode') === 'enabled') {
            document.body.classList.add("dark-mode");
        }
    }

    function toggleDarkMode() {
        var darkModeEnabled = document.body.classList.toggle("dark-mode");

        if (darkModeEnabled) {
            localStorage.setItem('dark-mode', 'enabled');
        } else {
            localStorage.removeItem('dark-mode');
        }
    }
    </script>

</body>
</html>
