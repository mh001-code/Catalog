<?php
header('Content-Type: application/json');
include '/xampp/htdocs/FurnitureCatalog/php/conection.php';

$data = json_decode(file_get_contents("php://input"), true);

try {
  $stmt = $pdo->prepare("UPDATE produtos SET 
    nome = :nome,
    descricao = :descricao,
    preco = :preco,
    imagem = :imagem,
    imagem_2 = :imagem_2,
    imagem_3 = :imagem_3,
    imagem_4 = :imagem_4,
    categoria = :categoria,
    subcategoria = :subcategoria,
    destaque = :destaque,
    mais_vendido = :mais_vendido,
    indisponivel = :indisponivel
    WHERE id = :id");

  $stmt->execute([
    ':id' => $data['id'],
    ':nome' => $data['nome'],
    ':descricao' => $data['descricao'],
    ':preco' => $data['preco'],
    ':imagem' => $data['imagem'],
    ':imagem_2' => $data['imagem_2'],
    ':imagem_3' => $data['imagem_3'],
    ':imagem_4' => $data['imagem_4'],
    ':categoria' => $data['categoria'],
    ':subcategoria' => $data['subcategoria'],
    ':destaque' => $data['destaque'],
    ':mais_vendido' => $data['mais_vendido'],
    ':indisponivel' => $data['indisponivel']
  ]);

  echo json_encode(['success' => true, 'message' => 'Produto atualizado com sucesso!']);
} catch (PDOException $e) {
  echo json_encode(['success' => false, 'message' => 'Erro ao atualizar: ' . $e->getMessage()]);
}
