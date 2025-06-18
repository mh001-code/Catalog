<?php
header('Content-Type: application/json');

// Inclui o arquivo de conexão
include 'conection.php'; // Inclui a conexão com o banco

if (!isset($_GET['id'])) {
    echo json_encode(["error" => "ID não fornecido."]);
    exit;
}

$id = $_GET['id'];

try {
    // Preparação e execução da consulta
    $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($produto) {
        echo json_encode($produto);
    } else {
        echo json_encode(["error" => "Produto não encontrado."]);
    }
} catch (PDOException $e) {
    // Caso ocorra erro na consulta ou na conexão
    echo json_encode(["error" => "Erro no banco de dados: " . $e->getMessage()]);
}
?>
