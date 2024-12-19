<?php
// order_details.php

include('includes/db.php'); // Include database connection

$order_id = intval($_GET['order_id']);

$sql = "SELECT * FROM orders WHERE id = $order_id";
$result = $conn->query($sql);
$order = $result->fetch_assoc();

echo "<h1>Order Details</h1>";
echo "<div>Order ID: " . htmlspecialchars($order['id']) . "</div>";
echo "<div>Status: " . htmlspecialchars($order['status']) . "</div>";

// Fetch payment details
$sql_payment = "SELECT * FROM payments WHERE order_id = $order_id";
$result_payment = $conn->query($sql_payment);
while ($payment = $result_payment->fetch_assoc()) {
    echo "<h2>Payment Details</h2>";
    echo "<div>Payment Status: " . htmlspecialchars($payment['payment_status']) . "</div>";
    echo "<div>Payment Method: " . htmlspecialchars($payment['payment_method']) . "</div>";
    echo "<div>Amount: " . htmlspecialchars($payment['amount']) . "</div>";
    echo "<div>Transaction ID: " . htmlspecialchars($payment['transaction_id']) . "</div>";
    echo "<h3>Payment Request Payload:</h3> <pre>" . htmlspecialchars($payment['payment_request_payload']) . "</pre>";
    echo "<h3>Payment Response Payload:</h3> <pre>" . htmlspecialchars($payment['payment_response_payload']) . "</pre>";
}

// Fetch refund details
$sql_refund = "SELECT * FROM refunds WHERE order_id = $order_id";
$result_refund = $conn->query($sql_refund);
if ($result_refund->num_rows > 0) {
    echo "<h2>Refund History</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Refund ID</th><th>Amount</th><th>Status</th><th>Request Payload</th><th>Response Payload</th><th>Created At</th><th>Updated At</th></tr>";
    while ($refund = $result_refund->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($refund['id']) . "</td>";
        echo "<td>" . htmlspecialchars($refund['amount']) . "</td>";
        echo "<td>" . htmlspecialchars($refund['refund_status']) . "</td>";
        echo "<td><pre>" . htmlspecialchars($refund['refund_request_payload']) . "</pre></td>";
        echo "<td><pre>" . htmlspecialchars($refund['refund_response_payload']) . "</pre></td>";
        echo "<td>" . htmlspecialchars($refund['created_at']) . "</td>";
        echo "<td>" . htmlspecialchars($refund['updated_at']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No refunds found for this order.</p>";
}

$conn->close();
?>
