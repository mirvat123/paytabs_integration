<?php
// process_checkout.php

session_start();
require_once 'includes/config.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if customer details exist in session
    if (!isset($_SESSION['customer_details']) || empty($_SESSION['customer_details'])) {
        die('Customer details are missing.');
    }

    // Retrieve customer details from session
    $customer_details = $_SESSION['customer_details'];
    $customer_name = $customer_details['customer_name'];
    $email = $customer_details['email'];
    $customer_phone = $customer_details['customer_phone'];
    $shipping_address = $customer_details['shipping_address'];
    $city = $customer_details['city'];
    $state = $customer_details['state'];
    $country = $customer_details['country'];
    $zip = $customer_details['zip'];
    $pickup = $customer_details['pickup'];

    // Retrieve cart items from session
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        die('Your cart is empty.');
    }

    // Calculate total amount
    $total_amount = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total_amount += $item['total'];
    }

    // Prepare PayTabs API request data
    $paytabs_data = [
        'profile_id' => PAYTABS_PROFILE_ID,
        'tran_type' => 'sale',
        'tran_class' => 'ecom',
        'cart_id' => 'cart_' . session_id(),
        'cart_currency' => 'EGP',
        'cart_amount' => number_format($total_amount, 2),
        'callback' => 'http://yourdomain.com/payment_callback.php',
        'return' => 'http://yourdomain.com/payment_return.php',
        'customer_details' => [
            'name' => $customer_name,
            'email' => $email,
            'phone' => $customer_phone,
            'street1' => $shipping_address,
            'city' => $city', // Add appropriate values
            'state' => $state', // Add appropriate values
            'country' => $country', // Add appropriate values
            'zip' => $zip // Add appropriate values
        ],
        'hide_shipping' => true, // Hide shipping details on payment form
        'hide_billing' => true // Hide billing details on payment form
    ];

    // Initialize cURL for the PayTabs API request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://secure.paytabs.com/payment/request");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($paytabs_data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: " . PAYTABS_SERVER_SECRET_KEY
    ]);

    // Execute the request and handle the response
    $response = curl_exec($ch);
    curl_close($ch);

    $response_data = json_decode($response, true);
    if (isset($response_data['redirect_url'])) {
        echo "<iframe src='{$response_data['redirect_url']}' width='600' height='400'></iframe>";
    } else {
        echo "Error: Unable to generate payment URL.";
    }
} else {
    echo 'Invalid request method.';
}
?>
