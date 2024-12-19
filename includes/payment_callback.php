<?php
include('includes/db.php'); // Include database connection

// Get the payment response payload
$payment_response = json_decode(file_get_contents('php://input'), true);

// Verify and process the payment response
$order_id = intval($payment_response['cart_id']);
$payment_status = $payment_response['response_code'] == "100" ? "paid" : "failed";
$amount = $payment_response['cart_amount'];
$transaction_id = $payment_response['tran_ref'];
$payment_request_payload = json_encode($payment_response['request']);
$payment_response_payload = json_encode($payment_response);

// Insert the payment details into the payments table
$sql_payment = "INSERT INTO payments (order_id, payment_status, payment_method, amount, transaction_id, payment_request_payload, payment_response_payload)
                VALUES ($order_id, '$payment_status', 'PayTabs', $amount, '$transaction_id', '$payment_request_payload', '$payment_response_payload')";

if ($conn->query($sql_payment) === TRUE) {
    // Update the order status in the orders table
    $conn->query("UPDATE orders SET status = '$payment_status' WHERE id = $order_id");

    // Redirect to the appropriate page based on payment status
    if ($payment_status == "paid") {
        header("Location: includes/success.php?order_id=$order_id&transaction_id=$transaction_id");
    } else {
        header("Location:includes/error.php?order_id=$order_id");
    }
} else {
    echo "Error: " . $sql_payment . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();
?>
