<?php
header('Content-Type: application/json');
include 'conection.php';

$termo = $_GET['q'] ?? '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("SELECT id, nome FROM produtos WHERE nome LIKE :pesquisa OR subcategoria LIKE :pesquisa LIMIT 8");
    $stmt->execute(['pesquisa' => '%' . $termo . '%']);
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($resultados);
} catch (PDOException $e) {
    echo json_encode(['erro' => $e->getMessage()]);
}
