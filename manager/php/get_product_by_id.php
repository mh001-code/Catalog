<?php
header('Content-Type: application/json');
include '/xampp/htdocs/Catalog/php/conection.php';

$id = $_GET['id'] ?? 0;

try {
    $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
    $stmt->execute([$id]);
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($produto ?: []);
} catch (PDOException $e) {
    echo json_encode([]);
}

