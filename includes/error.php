<?php
// error.php

$order_id = $_GET['order_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Error</title>
</head>
<body>
    <h1>Payment Failed</h1>
    <p>Unfortunately, your payment could not be processed. Please try again.</p>
    <p><a href="includes/checkout.php">Return to Checkout</a></p>
</body>
</html>

?>
