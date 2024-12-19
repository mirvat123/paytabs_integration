<?php
// success.php

$order_id = $_GET['order_id'];
$transaction_id = $_GET['transaction_id'];

// Fetch order details to confirm the status
include('includes/db.php');
$sql = "SELECT status FROM orders WHERE id = $order_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $order_status = $row['status'];
} else {
    die("Order not found.");
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Success</title>
</head>
<body>
    <h1>Payment Successful!</h1>
    <p>Thank you for your order. Your transaction ID is <?php echo htmlspecialchars($transaction_id); ?>.</p>
    <p>Order Status: <?php echo htmlspecialchars($order_status); ?></p>
    <p><a href="index.php">Return to Home</a></p>
</body>
</html>
