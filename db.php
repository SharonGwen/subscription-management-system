<?php
// php/db.php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
error_reporting(E_ALL); ini_set('display_errors', 1);

$host = 'localhost';
$user = 'root';
$pass = '';           // default XAMPP MySQL root has empty password
$db   = 'subscription_db';

try {
    $conn = new mysqli($host, $user, $pass, $db);
    $conn->set_charset('utf8mb4');
} catch (Exception $e) {
    // On failure, stop and show message
    http_response_code(500);
    die('Database connection failed: ' . $e->getMessage());
}
