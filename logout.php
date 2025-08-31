<?php
// php/logout.php
session_start();
session_unset();
session_destroy();
header('Location: /Subscription/login.html?success=' . urlencode('Logged out successfully.'));
exit;
