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
    background-color: #333;
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
    color: #fff;
    display: block;
    transition: 0.3s;
}

.sidebar a:hover {
    background-color: #444;
}

.toggle-btn {
    position: fixed;
    left: 20px;
    top: 20px;
    background-color: #333;
    color: white;
    padding: 10px 15px;
    font-size: 20px;
    border: none;
    cursor: pointer;
    z-index: 2;
}

.toggle-btn:hover {
    background-color: #444;
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
    <a href="employee_dashboard.php">Home</a>
    <a href="#">Manage Account</a>
    <a href="#">Services</a>
    <a href="#">Settings</a>
</div>


<script>
function toggleSidebar() {
    document.getElementById("sidebar").classList.toggle("active");
    document.getElementById("content").classList.toggle("shifted");
}
</script>

</body>
</html>