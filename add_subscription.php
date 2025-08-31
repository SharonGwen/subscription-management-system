<?php
// php/add_subscription.php
session_start();
header('Content-Type: application/json; charset=utf-8');
if (!isset($_SESSION['user_id'])) { echo json_encode(['success'=>false,'msg'=>'Not logged in']); exit; }
require __DIR__ . '/db.php';

$user_id = (int) $_SESSION['user_id'];
$service = trim($_POST['service_name'] ?? '');
$amount = $_POST['amount'] ?? '';
$next_payment = $_POST['next_payment'] ?? '';
$start_date = $_POST['start_date'] ?? date('Y-m-d');
$status = $_POST['status'] ?? 'Active';

$allowed_status = ['Active','Pending','Expired'];
if (!in_array($status, $allowed_status)) $status = 'Active';

$errors = [];
if ($service === '' || mb_strlen($service) > 100) $errors[] = 'Service name required (max 100).';
if (!is_numeric($amount) || floatval($amount) < 0) $errors[] = 'Amount must be a positive number.';
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $next_payment)) $errors[] = 'Next payment must be YYYY-MM-DD.';

if (!empty($errors)) { echo json_encode(['success'=>false,'errors'=>$errors]); exit; }

$amount = floatval($amount);

$stmt = $conn->prepare('INSERT INTO subscriptions (user_id, service_name, start_date, next_payment, amount, status) VALUES (?, ?, ?, ?, ?, ?)');
if (!$stmt) { echo json_encode(['success'=>false,'msg'=>'Prepare failed: '.$conn->error]); exit; }
$stmt->bind_param('issdss', $user_id, $service, $start_date, $next_payment, $amount, $status);
$ok = $stmt->execute();

if ($ok) {
    $id = $stmt->insert_id;
    $stmt->close();
    echo json_encode(['success'=>true,'id'=>$id,'msg'=>'Subscription added']);
} else {
    echo json_encode(['success'=>false,'msg'=>'Insert failed']);
}
exit;
