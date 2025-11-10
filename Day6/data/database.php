<?php
define('DB_HOST', "127.0.0.1");
define('DB_NAME', "iti"); 
define('DB_USER', "iti_user"); 
define('DB_PASS', "123456"); 
$pdo = null;
$error_message = "";

try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, 
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, 
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);

} catch (PDOException $e) {
    error_log("Database Connection Failed: " . $e->getMessage()); 
    $error_message = "Website is facing technical issues. Please try again later.";
    echo "<div style='background: #f12020ff; padding: 20px; border: 2px solid red; margin: 50px;'>";
    echo "<h1>Error</h1>";
    echo "<p>" . $error_message . "</p>";
    echo "</div>";
    exit; 
}

?>