<?php
include('config.php');
session_start();

$user_check = $_SESSION['login_user'];

$sql = "SELECT username FROM users WHERE username = :user_check";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_check', $user_check);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$login_session = $row['username'];

if (!isset($_SESSION['login_user'])) {
   header("location:login.php");
   die();
}
?>