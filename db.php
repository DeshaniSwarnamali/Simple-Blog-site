<?php
$host = 'localhost'; // Keep it as 'localhost' for local development
$db = 'blog_website'; // Your database name in MySQL Workbench
$user = 'root'; // Default username for MySQL
$pass = '1234'; // Your MySQL Workbench password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
