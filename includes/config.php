<?php
//config.php
// **PayTabs Configuration**

// PayTabs Profile ID (Get this from your PayTabs account)
define('PAYTABS_PROFILE_ID', '132344');  // Replace with your actual Profile ID

// PayTabs Server Key (Get this from your PayTabs account)
define('PAYTABS_SERVER_KEY', 'SWJ992BZTN-JHGTJBWDLM-BZJKMR2ZHT');  // Replace with your actual Server Key

// **Database Configuration** (Add your MySQL database connection settings here)
define('DB_HOST', 'localhost');   // Database server
define('DB_NAME', 'paytabs_integration');  // Database name
define('DB_USER', 'root');  // Database username
define('DB_PASS', '');  // Database password (empty for XAMPP default)

try {
    // Create a PDO instance for database connection
    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
    // Set PDO to throw exceptions on errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle database connection errors
    // You may want to log this error in a real-world application
    die("Database connection failed: " . $e->getMessage());
}
?>
