<?php
// db.php - Database connection file
 
$host = 'localhost'; // Assuming localhost; replace with actual host if different (e.g., for hosted DB like Neon/Postgres)
$dbname = 'dbfqguoyv1uxmg';
$user = 'um4u5gpwc3dwc';
$password = 'neqhgxo10ioe';
 
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
