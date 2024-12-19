<?php
// index.php

include('includes/db.php'); // Include database connection

// Fetch all products from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

echo "<h1>Welcome to Our Store</h1>";
echo "<p>Browse our selection of products and add them to your cart.</p>";

// Display the products in a list format
if ($result->num_rows > 0) {
    echo "<form method='POST' action='add_to_cart.php'>";
    echo "<table border='1'>";
    echo "<tr><th>Product ID</th><th>Name</th><th>Price</th><th>Quantity</th><th>Add to Cart</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['price']) . " EGP</td>";
        echo "<td><input type='number' name='quantity[" . $row['id'] . "]' value='1' min='1'></td>";
        echo "<td><button type='submit' name='add_to_cart' value='" . $row['id'] . "'>Add to Cart</button></td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</form>";
} else {
    echo "<p>No products available at the moment.</p>";
}

// Close the database connection
$conn->close();
?>

<!-- Links to other pages -->
<p><a href="order_history.php">View Order History</a></p>
<p><a href="includes/checkout.php">Proceed to Checkout</a></p>
