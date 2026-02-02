<?php
require 'db.php'; 

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php"); 
    exit; 
}

$id = (int) $_GET['id']; 

$stmt = $pdo->prepare("DELETE FROM books WHERE id = :id"); 

$stmt->execute([':id' => $id]); 

header("Location: index.php"); 
?>