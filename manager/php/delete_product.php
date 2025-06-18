<?php
header('Content-Type: application/json');
include '/xampp/htdocs/FurnitureCatalog/php/conection.php';

$id = $_GET['id'] ?? null;

if (!$id) {
  echo json_encode(['success' => false, 'message' => 'ID não fornecido.']);
  exit;
}

try {
  $stmt = $pdo->prepare("DELETE FROM produtos WHERE id = :id");
  $stmt->execute([':id' => $id]);

  if ($stmt->rowCount() > 0) {
    echo json_encode(['success' => true, 'message' => 'Produto excluído com sucesso.']);
  } else {
    echo json_encode(['success' => false, 'message' => 'Produto não encontrado.']);
  }
} catch (PDOException $e) {
  echo json_encode(['success' => false, 'message' => 'Erro ao excluir produto: ' . $e->getMessage()]);
}
