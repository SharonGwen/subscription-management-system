<?php
// php/login.php
session_start();
require __DIR__ . '/db.php';

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
    header('Location: /Subscription/login.html?error=' . urlencode('Please enter username and password.'));
    exit;
}

// Allow login by username OR email with one field
$q = $conn->prepare('SELECT id, username, password FROM users WHERE username = ? OR email = ? LIMIT 1');
$q->bind_param('ss', $username, $username);
$q->execute();
$res = $q->get_result();
$user = $res->fetch_assoc();
$q->close();

if (!$user || !password_verify($password, $user['password'])) {
    header('Location: /Subscription/login.html?error=' . urlencode('Invalid username/email or password.'));
    exit;
}

// Success
$_SESSION['user_id'] = $user['id'];
$_SESSION['username'] = $user['username'];

header('Location: /Subscription/dashboard.php');
exit;
