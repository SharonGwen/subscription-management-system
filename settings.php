<?php
$msg = "";
if(isset($_POST['save'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $msg = "Settings updated for $username ($email)";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Settings</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="style-sub.css">

</head>
<body>
<header>Subscription Dashboard</header>
<nav>
    <a href="index.php"><i class="fas fa-home"></i> Home</a>
    <a href="search.php"><i class="fas fa-search"></i> Search</a>
    <a href="reminders.php"><i class="fas fa-bell"></i> Reminders</a>
    <a href="settings.php"><i class="fas fa-cog"></i> Settings</a>
</nav>


<div class="container">
    <h2>Account Settings</h2>
    <?php if($msg) echo "<p style='color:green;'>$msg</p>"; ?>
    <form method="post">
        <label>Username:</label>
        <input type="text" name="username" required>
        
        <label>Email:</label>
        <input type="email" name="email" required>
        
        <button type="submit" name="save">Save Settings</button>
    </form>
</div>
</body>
</html>
