<?php
// php/edit_subscription.php
session_start();
header('Content-Type: application/json; charset=utf-8');
if (!isset($_SESSION['user_id'])) { echo json_encode(['success'=>false,'msg'=>'Not logged in']); exit; }
require __DIR__ . '/db.php';

$user_id = (int) $_SESSION['user_id'];
$id = intval($_POST['id'] ?? 0);
$service = trim($_POST['service_name'] ?? '');
$amount = $_POST['amount'] ?? '';
$next_payment = $_POST['next_payment'] ?? '';
$start_date = $_POST['start_date'] ?? date('Y-m-d');
$status = $_POST['status'] ?? 'Active';

$allowed_status = ['Active','Pending','Expired'];
if (!in_array($status, $allowed_status)) $status = 'Active';

$errors = [];
if ($id <= 0) $errors[] = 'Invalid ID.';
if ($service === '' || mb_strlen($service) > 100) $errors[] = 'Service name required.';
if (!is_numeric($amount) || floatval($amount) < 0) $errors[] = 'Amount must be a positive number.';
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $next_payment)) $errors[] = 'Next payment must be YYYY-MM-DD.';

if (!empty($errors)) { echo json_encode(['success'=>false,'errors'=>$errors]); exit; }

// ownership check
$chk = $conn->prepare('SELECT id FROM subscriptions WHERE id = ? AND user_id = ? LIMIT 1');
$chk->bind_param('ii', $id, $user_id);
$chk->execute();
$chk->store_result();
if ($chk->num_rows == 0) { echo json_encode(['success'=>false,'msg'=>'Not found or permission denied']); exit; }
$chk->close();

$amount = floatval($amount);
$stmt = $conn->prepare('UPDATE subscriptions SET service_name = ?, start_date = ?, next_payment = ?, amount = ?, status = ? WHERE id = ?');
$stmt->bind_param('sssdsi', $service, $start_date, $next_payment, $amount, $status, $id);
$ok = $stmt->execute();
if ($ok) echo json_encode(['success'=>true,'msg'=>'Updated']);
else echo json_encode(['success'=>false,'msg'=>'Update failed']);
exit;
