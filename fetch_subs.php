<?php
// fetch_subs.php
include 'db.php';

// Query to fetch subscriptions
$sql = "SELECT id, service_name, amount, billing_date, status FROM subscriptions ORDER BY billing_date ASC";
$result = $conn->query($sql);

$subscriptions = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $subscriptions[] = $row;
    }
}

// Return JSON data
header('Content-Type: application/json');
echo json_encode($subscriptions);

$conn->close();
?>
