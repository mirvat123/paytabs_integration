<?php
include($_SERVER['DOCUMENT_ROOT'] . '/paytabs_integration/includes/db.php');
$products = $pdo->query("SELECT * FROM products")->fetchAll();

foreach ($products as $row) {
    echo '<form action="add_to_cart.php" method="POST" class="add-to-cart-form">';
    echo '<input type="hidden" name="product_id" value="' . $row['id'] . '">';
    echo '<p>' . $row['product_name'] . '</p>';
    echo '<p>Price: ' . number_format($row['price'], 2) . ' EGP</p>';
    echo '<label for="quantity">Quantity:</label>';
    echo '<input type="number" name="quantity" min="1" value="1" required>';
    echo '<button type="submit" name='add_to_cart'>Add to Cart</button>';
    echo '</form>';
}
?>
