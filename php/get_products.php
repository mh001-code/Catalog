<?php
header('Content-Type: application/json');

// Inclui o arquivo de conexão
include 'conection.php'; // Inclui a conexão com o banco

// Obter categoria e subcategoria da URL
$categoria = $_GET['categoria'] ?? '';
$subcategoria = $_GET['subcategoria'] ?? '';

try {
    // Consulta SQL com base nos parâmetros
    $sql = "SELECT * FROM produtos WHERE categoria = :categoria";
    if (!empty($subcategoria)) {
        $sql .= " AND subcategoria = :subcategoria";
    }
    $sql .= " ORDER BY preco ASC;";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':categoria', $categoria);
    if (!empty($subcategoria)) {
        $stmt->bindParam(':subcategoria', $subcategoria);
    }

    $stmt->execute();
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retorna os produtos em formato JSON
    echo json_encode($produtos);
} catch (PDOException $e) {
    // Caso ocorra erro na consulta ou na conexão
    echo json_encode(['erro' => 'Erro ao conectar: ' . $e->getMessage()]);
}
