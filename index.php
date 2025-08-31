<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Subscription Manager</title>

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  
  <!-- FontAwesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  
  <!-- CSS -->
  <link rel="stylesheet" href="style1.css">
</head>
<body>
  <!-- Navbar -->
  <!-- Navbar -->
<nav class="navbar">
  <div class="logo">SubTrack</div>
  <div class="menu-icon" onclick="toggleMenu()">
  </div>
  <ul class="nav-links" id="navLinks">
    <a href="dashboard.php"><i class="fas fa-chart-line"></i> Dashboard </a>
    <a href="search.php"><i class="fas fa-search"></i> Search</a>
    <a href="reminders.php"><i class="fas fa-bell"></i> Reminders</a>
    <a href="settings.php"><i class="fas fa-cog"></i> Settings</a>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</nav>


  <!-- Hero Section -->
  <section class="hero">
    <div class="hero-text">
      <h1>Manage Your Subscriptions <br> <span>Smart & Easy</span></h1>
      <p>Track your bills, upcoming payments, and never miss a due date again!</p>
      <a href="login.html" class="btn">Get Started <i class="fa fa-arrow-right"></i></a>
    </div>
    <div class="hero-img">
      <i class="fa fa-credit-card fa-10x"></i>
    </div>
  </section>

  <script>
    function toggleMenu() {
      document.getElementById("navLinks").classList.toggle("show");
    }
  </script>
</body>
</html>
