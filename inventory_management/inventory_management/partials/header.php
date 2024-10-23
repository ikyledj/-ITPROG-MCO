<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Dashboard</title>
    <style>
        /* Header Bar Styles */
        .header-bar {
            width: 100%;
            height: 8.25%;
            background-color: #011F1D;
            color: white;
            padding: 10px 20px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo-container {
            display: flex;
            align-items: center;
        }

        .company-logo {
            height: 40px; /* Adjust size to fit your needs */
            margin-right: 15px;
        }

        .company-name {
            font-size: 24px;
            font-weight: bold;
            margin-left: 60px;
        }

        /* Sidebar toggle button */
        .toggle-btn {
            background-color: #333;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            z-index: 2;
        }

        .toggle-btn:hover {
            background-color: #444;
        }

        /* Adjust the main content so it doesn't overlap the header */
        .content {
            margin-top: 60px; /* Adjust according to the height of the header */
            padding: 20px;
            transition: 0.3s;
        }

        .content.shifted {
            margin-left: 250px;
        }
    </style>
</head>
<body>

    <!-- Header Bar -->
    <header class="header-bar">
        <div class="logo-container">
            <!-- <img src="" alt="Company Logo" class="company-logo"> -->
            <span class="company-name">Company Name</span>
        </div>
        <!-- Sidebar Toggle Button -->
        <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
    </header>

    <script>
    function toggleSidebar() {
        document.getElementById("sidebar").classList.toggle("active");
        document.getElementById("content").classList.toggle("shifted");
    }
    </script>

    <style>
        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: -250px;
            background-color: #333;
            padding-top: 60px;
            transition: 0.3s;
            z-index: 1;
        }

        .sidebar.active {
            left: 0;
        }

        .sidebar a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 18px;
            color: #fff;
            display: block;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background-color: #444;
        }
    </style>
</body>
</html>
