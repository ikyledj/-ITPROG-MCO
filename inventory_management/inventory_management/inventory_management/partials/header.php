<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Dashboard</title>
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
