<?php
$host = "localhost";
$user = "root";
$password = "";
$db_name = "autoszerelo_munkalapok";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name", $user, $password);
    
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("SET CHARACTER SET utf8mb4");
} catch(PDOException $e) {
    die("Hiba: " . $e->getMessage());
}
?>