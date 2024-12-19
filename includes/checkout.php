<?php
// checkout.php

session_start();

// Generate a new CSRF token for security
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
// Store customer details in session
        $_SESSION['customer_details'] = [
            'customer_name' => htmlspecialchars(trim($_POST['customer_name'])),
            'email' => htmlspecialchars(trim($_POST['email'])),
            'customer_phone' => htmlspecialchars(trim($_POST['customer_phone'])),
            'shipping_address' => htmlspecialchars(trim($_POST['shipping_address'])),
            'pickup' => isset($_POST['pickup']) ? 1 : 0 // 1 for Pickup, 0 for Shipping
        ];
// Check if the cart is not empty
if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    echo '<h1>Checkout</h1>';
    echo '<form id="checkout-form" method="POST" action="process_checkout.php">';

    // Display cart items
    echo '<table>';
    echo '<tr><th>Product</th><th>Price</th><th>Quantity</th><th>Total</th></tr>';

    $total_amount = 0;
    foreach ($_SESSION['cart'] as $item) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($item['name']) . '</td>';
        echo '<td>' . number_format($item['price'], 2) . ' EGP</td>';
        echo '<td>' . htmlspecialchars($item['quantity']) . '</td>';
        echo '<td>' . number_format($item['total'], 2) . ' EGP</td>';
        echo '</tr>';
        $total_amount += $item['total'];
    }

    echo '</table>';
    echo '<p>Total Amount: ' . number_format($total_amount, 2) . ' EGP</p>';

    // Collect customer details
    echo '<input type="text" name="customer_name" placeholder="Enter your name" required>';
    echo '<br><input type="email" name="email" placeholder="Enter your email" required>';
    echo '<br><input type="text" name="customer_phone" placeholder="Enter your phone number" required>';
    echo '<br><input type="text" name="shipping_address" placeholder="Enter your shipping address" required>';
	   echo '<br><input type="text" name="city" placeholder="city" required>';
	   echo '<br><input type="text" name="state" placeholder="state" required>';
	   echo '<br><input type="text" name="country" placeholder="country" required>';
	   echo '<br><input type="number_format" name="zip" placeholder="zip" required>';
	   
    echo '<br><label for="pickup">Pick Up: </label><input type="checkbox" name="pickup">';

    // CSRF protection
    echo '<input type="hidden" name="csrf_token" value="' . $_SESSION['csrf_token'] . '">';

    echo '<button type="submit">Proceed to Payment</button>';
    echo '</form>';

    // Placeholder for payment iframe
    echo '<div id="payment-iframe"></div>';
?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#checkout-form').on('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            $.ajax({
                url: 'process_checkout.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#payment-iframe').html(response); // Load the payment iframe
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error:', textStatus, errorThrown);
                    alert('An error occurred while processing your request. Please try again.');
                }
            });
        });
    });
    </script>
<?php
} else {
    echo 'Your cart is empty. Please add items to the cart first.';
}
?>
