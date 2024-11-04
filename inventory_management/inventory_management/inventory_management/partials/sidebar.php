<!DOCTYPE html>
<html>
<head>
</head>
<body>

<div class="sidebar" id="sidebar">
    <div class="menu-items">
        <a href="employee_dashboard.php">
            <img src="logo-icons/Home Stroke Rounded.svg" alt="Home Icon">
            <span>Home</span>
        </a>
        <a href="change_password.php">
            <img src="logo-icons/Account Setting Rounded.svg" alt="Manage Account Icon">
            <span>Manage Account</span>
        </a>
        <a href="transaction_history.php">
            <img src="logo-icons/Clock 02 Rounded.svg" alt="History Icon">
            <span>Transaction History</span>
        </a>
    </div>
    <div class="bottom-container">
        <a href="javascript:void(0);" onclick="toggleDarkMode()">
            <img src="logo-icons/Moon 02 Rounded.svg" alt="Dark Mode Icon">
            <span>Dark Mode</span>
        </a>
        <a href="logout.php">
            <img src="logo-icons/Logout square stroke rounded.svg" alt="Logout Icon">
            <span>Logout</span>
        </a>
    </div>
</div>

<script>
function toggleSidebar() {
    document.getElementById("sidebar").classList.toggle("active");
    document.getElementById("content").classList.toggle("shifted");
}
</script>

<script>
// On page load, check if dark mode is saved in local storage
window.onload = function() {
    if (localStorage.getItem('dark-mode') === 'enabled') {
        document.body.classList.add("dark-mode");
        document.getElementById("sidebar").classList.add("dark-mode");

        var links = document.querySelectorAll(".sidebar a");
        links.forEach(function(link) {
            link.classList.add("dark-mode");
        });
    }
}

function toggleDarkMode() {
    var darkModeEnabled = document.body.classList.toggle("dark-mode");
    
    document.getElementById("sidebar").classList.toggle("dark-mode");

    var links = document.querySelectorAll(".sidebar a");
    links.forEach(function(link) {
        link.classList.toggle("dark-mode");
    });

    if (darkModeEnabled) {
        localStorage.setItem('dark-mode', 'enabled');
    } else {
        localStorage.removeItem('dark-mode');
    }
}
</script>


</body>
</html>