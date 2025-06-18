<?php
header('Content-Type: application/json');
include '/xampp/htdocs/FurnitureCatalog/php/conection.php';

$termo = $_GET['termo'] ?? '';
$termo = strtolower(preg_replace('/\s+/', '%', $termo));

$stmt = $pdo->prepare("SELECT id, nome FROM produtos WHERE LOWER(REPLACE(REPLACE(REPLACE(REPLACE(nome, '-', ' '), '/', ''), 'ç', 'c'), 'áéíóúãõâêîôûàèìòùäëïöü', '') ) LIKE ?");
$stmt->execute(["%$termo%"]);

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
