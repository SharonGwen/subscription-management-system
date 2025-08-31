<?php
$result = "";
if(isset($_POST['search'])){
    $query = $_POST['query'];
    $result = "Results for: $query (Demo only, no DB linked)";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Search</title>
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
    <h2>Search Subscriptions</h2>
    <form method="post">
        <label>Enter Subscription Name:</label>
        <input type="text" name="query" placeholder="e.g. Netflix, Spotify" required>
        <button type="submit" name="search">Search</button>
    </form>
    <?php if($result) echo "<p style='margin-top:20px; color:green;'>$result</p>"; ?>
</div>
</body>
</html>
