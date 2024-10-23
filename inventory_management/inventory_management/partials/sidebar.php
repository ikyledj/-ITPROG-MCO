<!DOCTYPE html>
<html>
<head>
<style>
.sidebar {
    height: 100%;
    width: 200px;
    position: fixed;
    top: 0;
    left: -250px;
    background-color: #011F1D;
    padding-top: 70px;
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
    color: #717F7E;
    display: flex; /* Use flexbox to align icon and text */
    align-items: center;
    transition: 0.3s;
}

.sidebar a img {
    margin-right: 10px; /* Space between icon and text */
    width: 20px; /* Adjust size */
    height: 20px;
}

.sidebar a:hover {
    background-color: #011F1D;
    color: #fff;
}

.toggle-btn {
    position: fixed;
    left: 20px;
    top: 20px;
    background-color: #011F1D;
    color: #717F7E;
    padding: 10px 15px;
    font-size: 20px;
    border: none;
    cursor: pointer;
    z-index: 2;
}

.toggle-btn:hover {
    background-color: #011F1D;
    color: #fff;
}

.content {
    margin-left: 0;
    padding: 20px;
    transition: 0.3s;
}

.content.shifted {
    margin-left: 250px;
}
</style>
</head>
<body>

<button class="toggle-btn" onclick="toggleSidebar()">☰</button>

<div class="sidebar" id="sidebar">
    <a href="employee_dashboard.php">
        <img src="logo-icons/Home Stroke Rounded.svg" alt="Home Icon">
        Home
    </a>
    <a href="#">
        <img src="logo-icons/Account Setting Rounded.svg" alt="Manage Account Icon">
        Manage Account
    </a>
    <a href="#">
        <img src="logo-icons/Moon 02 Rounded.svg" alt="Dark Mode Icon">
        Dark Mode
    </a>
    <a href="logout.php">
        <img src="logo-icons/Logout square stroke rounded.svg" alt="Logout Icon">
        Logout
    </a>
</div>

<script>
function toggleSidebar() {
    document.getElementById("sidebar").classList.toggle("active");
    document.getElementById("content").classList.toggle("shifted");
}
</script>

</body>
</html>
