<?php
// order_history.php

include('includes/db.php'); // Include database connection

// Fetch all orders from the database
$sql = "SELECT o.*, p.payment_request_payload, p.payment_response_payload 
        FROM orders o
        LEFT JOIN payments p ON o.id = p.order_id";
$result = $conn->query($sql);

echo "<h1>Order History</h1>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<h2>Order ID: " . htmlspecialchars($row['id']) . "</h2>";
        echo "<p>Status: " . htmlspecialchars($row['status']) . "</p>";
        echo "<h3>Payment Details</h3>";
        echo "<p>Payment Request Payload:</p> <pre>" . htmlspecialchars($row['payment_request_payload']) . "</pre>";
        echo "<p>Payment Response Payload:</p> <pre>" . htmlspecialchars($row['payment_response_payload']) . "</pre>";

        // Fetch refund details for this order
        $refund_sql = "SELECT * FROM refunds WHERE order_id = " . intval($row['id']);
        $refund_result = $conn->query($refund_sql);
        if ($refund_result->num_rows > 0) {
            echo "<h3>Refund History</h3>";
            echo "<table border='1'>";
            echo "<tr><th>Refund ID</th><th>Amount</th><th>Status</th><th>Request Payload</th><th>Response Payload</th><th>Created At</th><th>Updated At</th></tr>";
            while ($refund_row = $refund_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($refund_row['id']) . "</td>";
                echo "<td>" . htmlspecialchars($refund_row['amount']) . "</td>";
                echo "<td>" . htmlspecialchars($refund_row['refund_status']) . "</td>";
                echo "<td><pre>" . htmlspecialchars($refund_row['refund_request_payload']) . "</pre></td>";
                echo "<td><pre>" . htmlspecialchars($refund_row['refund_response_payload']) . "</pre></td>";
                echo "<td>" . htmlspecialchars($refund_row['created_at']) . "</td>";
                echo "<td>" . htmlspecialchars($refund_row['updated_at']) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No refunds found for this order.</p>";
        }
        echo "</div><hr>";
    }
} else {
    echo "<p>No past orders found.</p>";
}

$conn->close();
?>
