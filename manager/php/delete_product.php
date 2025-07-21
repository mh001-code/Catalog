<?php
header('Content-Type: application/json');
include '/xampp/htdocs/Catalog/php/conection.php';

$id = $_GET['id'] ?? null;

if (!$id) {
  echo json_encode(['success' => false, 'message' => 'ID não fornecido.']);
  exit;
}

$imageDir = '/xampp/htdocs/Catalog/img/product_images/';

try {
  // Pega as imagens associadas ao produto
  $stmtImages = $pdo->prepare("SELECT imagem FROM produtos WHERE id = :id");
  $stmtImages->execute([':id' => $id]);
  $imagens = $stmtImages->fetchAll(PDO::FETCH_COLUMN);

  // Remove o produto do banco
  $stmtDelete = $pdo->prepare("DELETE FROM produtos WHERE id = :id");
  $stmtDelete->execute([':id' => $id]);

  if ($stmtDelete->rowCount() > 0) {
    $imgsDeletadas = [];
    $imgsNaoEncontradas = [];

    foreach ($imagens as $img) {
      // Corrige o caminho: extrai apenas o nome da imagem
      $nomeArquivo = basename($img);
      $filePath = $imageDir . $nomeArquivo;

      if (file_exists($filePath)) {
        if (unlink($filePath)) {
          $imgsDeletadas[] = $nomeArquivo;
        } else {
          $imgsNaoEncontradas[] = $nomeArquivo; // erro ao tentar deletar
        }
      } else {
        $imgsNaoEncontradas[] = $nomeArquivo;
      }
    }

    echo json_encode([
      'success' => true,
      'message' => 'Produto e imagem(ns) excluídos.',
      'imagens_deletadas' => $imgsDeletadas,
      'imagens_nao_encontradas' => $imgsNaoEncontradas
    ]);
  } else {
    echo json_encode(['success' => false, 'message' => 'Produto não encontrado.']);
  }
} catch (PDOException $e) {
  echo json_encode(['success' => false, 'message' => 'Erro: ' . $e->getMessage()]);
}
