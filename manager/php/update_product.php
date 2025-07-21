<?php
header('Content-Type: application/json');
include '/xampp/htdocs/Catalog/php/conection.php';

$data = json_decode(file_get_contents("php://input"), true);

// Caminho base absoluto da raiz do servidor (ex: C:/xampp/htdocs/)
$imageDirBase = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/';

try {
  // 1. Buscar imagens atuais do produto
  $stmtCurrent = $pdo->prepare("SELECT imagem, imagem_2, imagem_3, imagem_4, imagem_5, imagem_6, imagem_7, imagem_8 FROM produtos WHERE id = :id");
  $stmtCurrent->execute([':id' => $data['id']]);
  $current = $stmtCurrent->fetch(PDO::FETCH_ASSOC);

  if (!$current) {
    echo json_encode(['success' => false, 'message' => 'Produto não encontrado.']);
    exit;
  }

  // 2. Campos de imagens que vamos comparar
  $imagensCampos = ['imagem', 'imagem_2', 'imagem_3', 'imagem_4', 'imagem_5', 'imagem_6', 'imagem_7', 'imagem_8'];

  // 3. Comparar imagens antigas com as novas e excluir as antigas alteradas
  foreach ($imagensCampos as $campo) {
    $antiga = $current[$campo] ?? '';
    $nova = $data[$campo] ?? '';

    // Se mudou e o caminho antigo não está vazio
    if ($nova !== $antiga && !empty($antiga)) {
      // Remove barra inicial se houver para evitar erro no caminho
      $antigaTrimmed = ltrim($antiga, '/\\');
      $caminhoCompleto = $imageDirBase . $antigaTrimmed;

      if (file_exists($caminhoCompleto)) {
        unlink($caminhoCompleto);
      }
    }
  }

  // 4. Atualizar o produto no banco
  $stmt = $pdo->prepare("UPDATE produtos SET 
    nome = :nome,
    descricao = :descricao,
    preco = :preco,
    imagem = :imagem,
    imagem_2 = :imagem_2,
    imagem_3 = :imagem_3,
    imagem_4 = :imagem_4,
    imagem_5 = :imagem_5,
    imagem_6 = :imagem_6,
    imagem_7 = :imagem_7,
    imagem_8 = :imagem_8,
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
    ':imagem_5' => $data['imagem_5'],
    ':imagem_6' => $data['imagem_6'],
    ':imagem_7' => $data['imagem_7'],
    ':imagem_8' => $data['imagem_8'],
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
