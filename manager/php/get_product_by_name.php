<?php
header('Content-Type: application/json');
include '/xampp/htdocs/FurnitureCatalog/php/conection.php';

$nome = $_GET['nome'] ?? '';

try {
    $stmt = $pdo->prepare("SELECT id, nome FROM produtos WHERE REPLACE(LOWER(nome), '-', '') LIKE :nome");
    $nomeFormatado = '%' . str_replace(' ', '', strtolower($nome)) . '%';
    $stmt->execute([':nome' => $nomeFormatado]);
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($produtos);
} catch (PDOException $e) {
    echo json_encode([]);
}
