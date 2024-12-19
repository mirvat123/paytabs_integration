<?php
include($_SERVER['DOCUMENT_ROOT'] . '/paytabs_integration/includes/products.php');
session_start();
//This script processes the product selection and stores it in the session
// Ensure the 'add_to_cart' button was pressed 
if (isset($_POST['add_to_cart'])) { 
                        $product_id = intval($_POST['add_to_cart']); 
						$quantity = intval($_POST['quantity'][$product_id]);
// Check if cart exists
if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    echo '<h1>Your Cart</h1>';
    echo '<table>';
    echo '<tr><th>Product</th><th>Price</th><th>Quantity</th><th>Total</th></tr>';

    $total_amount = 0;
    foreach ($_SESSION['cart'] as $item) {
        echo '<tr>';
        echo '<td>' . $item['name'] . '</td>';
        echo '<td>' . number_format($item['price'], 2) . ' EGP</td>';
        echo '<td>' . $item['quantity'] . '</td>';
        echo '</tr>';
        $total_amount += $item['total'];
    }

    echo '</table>';
    echo '<p>Total Amount: ' . number_format($total_amount, 2) . ' EGP</p>';
    echo '<a href="includes/checkout.php">Proceed to Checkout</a>';
} else {
    echo 'Your cart is empty.';
}
?>
