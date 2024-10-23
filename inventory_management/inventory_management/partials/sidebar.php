<!DOCTYPE html>
<html>
<head>
<style>
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
}

.sidebar:hover {
    width: 240px;
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
}

.sidebar:hover + .content {
    margin-left: 240px;
}
</style>
</head>
<body>

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
