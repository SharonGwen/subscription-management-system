<?php
$message = "";
if(isset($_POST['send'])){
    $email = $_POST['email'];
    $message = "Reminder email would be sent to $email successfully!";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reminders</title>
    <link rel="stylesheet" href="style-sub.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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
    <h2>Send Payment Reminder</h2>
    <?php if($message) echo "<p style='color:green;'>$message</p>"; ?>
    <form method="post">
        <label>Email Address:</label>
        <input type="email" name="email" required>
        <button type="submit" name="send">Send Reminder</button>
    </form>
</div>
</body>
</html>
