<?php
session_start();

if (!isset($_SESSION['logado'])) {
  header('Location: login');
  exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Adicionar Produto</title>
  <link rel="stylesheet" href="/Catalog/css/styles.css">
  <link rel="icon" href="/img/icons/favicon1.png" type="image/x-icon">
</head>

<body>
  <div class="admin-container">
    <h2>Adicionar Produto</h2>

    <form id="product-form" enctype="multipart/form-data" method="POST" action="/Catalog/manager/php/add_product.php">
      <label for="nome">Nome:</label>
      <input type="text" id="nome" name="nome" required>

      <label for="preco">Preço:</label>
      <input type="number" step="0.01" id="preco" name="preco" required>

      <label for="descricao">Descrição:</label>
      <textarea id="descricao" name="descricao" required></textarea>

      <label for="imagem">Imagem Principal:</label>
      <input type="file" id="imagem" name="imagem" accept="image/*" required>
      <img id="preview-imagem" style="max-width: 150px; margin-top: 5px; display: none;">


      <label for="imagem_2">Imagem Extra 2:</label>
      <input type="file" id="imagem_2" name="imagem_2" accept="image/*">
      <img id="preview-imagem_2" style="max-width: 150px; margin-top: 5px; display: none;">

      <label for="imagem_3">Imagem Extra 3:</label>
      <input type="file" id="imagem_3" name="imagem_3" accept="image/*">
      <img id="preview-imagem_3" style="max-width: 150px; margin-top: 5px; display: none;">

      <label for="imagem_4">Imagem Extra 4:</label>
      <input type="file" id="imagem_4" name="imagem_4" accept="image/*">
      <img id="preview-imagem_4" style="max-width: 150px; margin-top: 5px; display: none;">

      <label for="imagem_5">Imagem Extra 5:</label>
      <input type="file" id="imagem_5" name="imagem_5" accept="image/*">
      <img id="preview-imagem_5" style="max-width: 150px; margin-top: 5px; display: none;">

      <label for="imagem_6">Imagem Extra 6:</label>
      <input type="file" id="imagem_6" name="imagem_6" accept="image/*">
      <img id="preview-imagem_6" style="max-width: 150px; margin-top: 5px; display: none;">

      <label for="imagem_7">Imagem Extra 7:</label>
      <input type="file" id="imagem_7" name="imagem_7" accept="image/*">
      <img id="preview-imagem_7" style="max-width: 150px; margin-top: 5px; display: none;">

      <label for="imagem_8">Imagem Extra 8:</label>
      <input type="file" id="imagem_8" name="imagem_8" accept="image/*">
      <img id="preview-imagem_8" style="max-width: 150px; margin-top: 5px; display: none;">

      <label for="categoria">Categoria:</label>
      <select id="categoria" name="categoria" required>
        <option value="">Selecione...</option>
      </select>


      <label for="subcategoria">Subcategoria:</label>
      <select id="subcategoria" name="subcategoria" required>
        <option value="">Selecione uma categoria primeiro</option>
      </select>

      <label><input type="checkbox" id="destaque" name="destaque"> Novidades 🔥</label>
      <label><input type="checkbox" id="mais_vendido" name="mais_vendido"> Os Mais Desejados 👑</label>
      <label><input type="checkbox" id="indisponivel" name="indisponivel"> Indisponível ❌</label>

      <button type="submit">Adicionar Produto</button>
    </form>
    <div class="voltar-container">
      <a href="/Catalog/admin" class="btn-voltar">← Voltar ao Painel</a>
    </div>


    <p id="mensage"></p>

  </div>

  <script src="/Catalog/manager/js/add_product.js"></script>
  <script src="/Catalog/manager/js/script.js"></script>
</body>

</html>