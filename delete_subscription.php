<?php
// php/delete_subscription.php
session_start();
header('Content-Type: application/json; charset=utf-8');
if (!isset($_SESSION['user_id'])) { echo json_encode(['success'=>false,'msg'=>'Not logged in']); exit; }
require __DIR__ . '/db.php';

$user_id = (int) $_SESSION['user_id'];
$id = intval($_POST['id'] ?? 0);
if ($id <= 0) { echo json_encode(['success'=>false,'msg'=>'Invalid id']); exit; }

$chk = $conn->prepare('SELECT id FROM subscriptions WHERE id = ? AND user_id = ? LIMIT 1');
$chk->bind_param('ii', $id, $user_id);
$chk->execute();
$chk->store_result();
if ($chk->num_rows == 0) { echo json_encode(['success'=>false,'msg'=>'Not found or permission denied']); exit; }
$chk->close();

$stmt = $conn->prepare('DELETE FROM subscriptions WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
if ($stmt->affected_rows > 0) echo json_encode(['success'=>true,'msg'=>'Deleted']);
else echo json_encode(['success'=>false,'msg'=>'Delete failed']);
exit;
