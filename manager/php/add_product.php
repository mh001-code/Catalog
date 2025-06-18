<?php
header('Content-Type: application/json');
include '/xampp/htdocs/FurnitureCatalog/php/conection.php';

function salvarImagem($arquivo) {
    $pastaRelativa = '/img/product_images/';
    $pastaAbsoluta = $_SERVER['DOCUMENT_ROOT'] . $pastaRelativa;

    // Garante que a pasta existe
    if (!is_dir($pastaAbsoluta)) {
        mkdir($pastaAbsoluta, 0755, true);
    }

    if (isset($arquivo) && $arquivo['error'] === UPLOAD_ERR_OK) {
        $extensao = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
        $nomeUnico = uniqid() . "." . $extensao;
        $caminhoCompleto = $pastaAbsoluta . $nomeUnico;

        if (move_uploaded_file($arquivo['tmp_name'], $caminhoCompleto)) {
            // Caminho que será salvo no banco (relativo ao site)
            return $pastaRelativa . $nomeUnico;
        }
    }

    return null;
}


$nome = $_POST['nome'];
$descricao = $_POST['descricao'];
$preco = $_POST['preco'];
$categoria = $_POST['categoria'];
$subcategoria = $_POST['subcategoria'];
$destaque = (isset($_POST['destaque']) && $_POST['destaque'] == '1') ? 0 : 1;
$mais_vendido = (isset($_POST['mais_vendido']) && $_POST['mais_vendido'] == '1') ? 0 : 1;
$indisponivel = (isset($_POST['indisponivel']) && $_POST['indisponivel'] == '1') ? 0 : 1;

$imagem = salvarImagem($_FILES['imagem']);
$imagem_2 = salvarImagem($_FILES['imagem_2']);
$imagem_3 = salvarImagem($_FILES['imagem_3']);
$imagem_4 = salvarImagem($_FILES['imagem_4']);

try {
    $stmt = $pdo->prepare("INSERT INTO produtos 
        (nome, descricao, preco, imagem, imagem_2, imagem_3, imagem_4, categoria, subcategoria, destaque, mais_vendido, indisponivel)
        VALUES (:nome, :descricao, :preco, :imagem, :imagem_2, :imagem_3, :imagem_4, :categoria, :subcategoria, :destaque, :mais_vendido, :indisponivel)");

    $stmt->execute([
        ':nome' => $nome,
        ':descricao' => $descricao,
        ':preco' => $preco,
        ':imagem' => $imagem,
        ':imagem_2' => $imagem_2,
        ':imagem_3' => $imagem_3,
        ':imagem_4' => $imagem_4,
        ':categoria' => $categoria,
        ':subcategoria' => $subcategoria,
        ':destaque' => $destaque,
        ':mais_vendido' => $mais_vendido,
        ':indisponivel' => $indisponivel
    ]);

    echo json_encode(['success' => true, 'message' => 'Produto adicionado com sucesso!']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erro ao adicionar produto: ' . $e->getMessage()]);
}
