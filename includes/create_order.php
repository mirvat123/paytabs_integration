<?php
//create_order.php
//This file will handle creating a new order. 
//It inserts order details into the orders table and provides the order ID for the user to proceed with payment.
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_name = $_POST['customer_name'];
    $email = $_POST['email'];
    $customer_phone = $_POST['customer_phone'];
    $shipping_address = $_POST['shipping_address'];
    $pickup = isset($_POST['pickup']) ? 1 : 0;

    $sql = "INSERT INTO orders (customer_name, email, customer_phone, shipping_address, pickup, status) 
            VALUES ('$customer_name', '$email', '$customer_phone', '$shipping_address', '$pickup', 'pending')";

    if ($conn->query($sql) === TRUE) {
        $order_id = $conn->insert_id; // Get the new order ID
        echo json_encode(["order_id" => $order_id]);
    } else {
        echo json_encode(["error" => "Error creating order: " . $conn->error]);
    }
}
?>
