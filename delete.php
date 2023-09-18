<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('config.php');
$pdo->exec("SET NAMES 'utf8mb4'");
$sql = "DELETE FROM autok WHERE `auto_id` = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
if($stmt->execute()){
	header("Location:index.php");
	exit;
}else{
	$error =  $stmt->errorInfo();
	echo "Hiba: " . $error[2];
}
?>
