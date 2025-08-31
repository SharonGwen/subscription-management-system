<?php
// php/register.php
require __DIR__ . '/db.php';

$name     = trim($_POST['name']     ?? '');
$username = trim($_POST['username'] ?? '');
$email    = trim($_POST['email']    ?? '');
$password = $_POST['password']      ?? '';

if ($name === '' || $username === '' || $email === '' || strlen($password) < 6) {
    header('Location: /Subscription/register.html?error=' . urlencode('Fill all fields correctly.'));
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: /Subscription/register.html?error=' . urlencode('Invalid email address.'));
    exit;
}

// Check if user exists
$stmt = $conn->prepare('SELECT id FROM users WHERE email = ? OR username = ? LIMIT 1');
$stmt->bind_param('ss', $email, $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->close();
    header('Location: /Subscription/register.html?error=' . urlencode('User already exists. Try another email/username.'));
    exit;
}

$stmt->close();

// Insert
$hash = password_hash($password, PASSWORD_BCRYPT);
$ins = $conn->prepare('INSERT INTO users (name, username, email, password) VALUES (?, ?, ?, ?)');
$ins->bind_param('ssss', $name, $username, $email, $hash);
$ins->execute();
$ins->close();

header('Location: /Subscription/login.html?success=' . urlencode('Account created! Please log in.'));
exit;
