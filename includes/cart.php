<?php
//Once the user has added products to the cart, display it with quantity and price information on a separate cart page
session_start();

// Database connection
include('includes/db.php');

// Check if the required POST data is available
if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_id = $_POST['product_id'];
    $quantity = intval($_POST['quantity']);  // Ensure the quantity is an integer

    // Ensure quantity is greater than 0
    if ($quantity <= 0) {
        echo "Quantity must be greater than zero.";
        exit();
    }

    // Fetch product details from the database
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();

    if ($product) {
        // Add product to the cart in the session
        $cart_item = [
            'product_id' => $product_id,
            'name' => $product['product_name'],
            'price' => $product['price'],
            'quantity' => $quantity,
            'total' => $product['price'] * $quantity
        ];

        // If the cart already exists in session, update it
        if (isset($_SESSION['cart'])) {
            $found = false;
            foreach ($_SESSION['cart'] as $index => $item) {
                if ($item['product_id'] == $product_id) {
                    $_SESSION['cart'][$index]['quantity'] += $quantity;
                    $_SESSION['cart'][$index]['total'] = $_SESSION['cart'][$index]['price'] * $_SESSION['cart'][$index]['quantity'];
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $_SESSION['cart'][] = $cart_item;
            }
        } else {
            $_SESSION['cart'] = [$cart_item];
        }

        echo "Product added to cart!";
    } else {
        echo "Product not found.";
    }
} else {
    echo "Invalid request.";
}
?>
