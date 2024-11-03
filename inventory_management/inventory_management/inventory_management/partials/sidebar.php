<!DOCTYPE html>
<html>
<head>
<style>

body {
    background-color: var(--bg-primary);
    color: var(--text-primary);
    transition: background-color 0.4s ease, color 0.4s ease;
}
.sidebar {
    height: 90%; 
    width: 60px;
    position: fixed;
    top: 10%; 
    left: 0;
    background-color: #011F1D;
    padding-top: 20px; 
    display: flex;
    flex-direction: column;
    transition: all 0.3s ease;
    overflow-x: hidden;
    white-space: nowrap;
    border-top-right-radius: 10px;
    border-bottom-right-radius: 20px;
    z-index: 1;
}

.sidebar.active {
    width: 240px;
}

.sidebar:hover {
    width: 240px;
}

/* Main menu container */
.menu-items {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

/* Logout container */
.bottom-container {
    margin-top: auto;
    padding-bottom: 20px;
}

.sidebar:hover ~ .content,
.sidebar.active ~ .content {
    margin-left: 240px;
}

.sidebar a {
    position: relative;
    margin: 4px 8px;
    padding: 12px 13px;
    text-decoration: none;
    font-size: 16px;
    color: #717F7E;
    display: flex;
    align-items: center;
    transition: 0.3s;
    border-radius: 15px;
}

.sidebar a img {
    min-width: 20px;
    height: 20px;
    margin-right: 18px;
}

.sidebar a span {
    transform: translateX(-100%);
    opacity: 0;
    transition: all 0.3s ease;
    position: relative;
    display: inline-block;
}

.sidebar.active a span,
.sidebar:hover a span {
    transform: translateX(0);
    opacity: 1;
}

.sidebar a:hover {
    background-color: #267058;
    color: #fff;
}

.content {
    margin-left: 60px;
    padding: 20px;
    transition: margin-left 0.3s ease;
    z-index: 0;
}

.toggle-btn {
    position: fixed;
    top: 20px;
    left: 10px;
    background-color: #333;
    color: white;
    padding: 10px;
    font-size: 18px;
    border: none;
    cursor: pointer;
    z-index: 1000;
}

.toggle-btn:hover {
    background-color: #444;
}
</style>
</head>
<body>

<div class="sidebar" id="sidebar">
    <div class="menu-items">
        <a href="employee_dashboard.php">
            <img src="logo-icons/Home Stroke Rounded.svg" alt="Home Icon">
            <span>Home</span>
        </a>
        <a href="#">
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