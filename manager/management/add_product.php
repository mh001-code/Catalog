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

      <label for="imagem_2">Imagem Extra 2:</label>
      <input type="file" id="imagem_2" name="imagem_2" accept="image/*">

      <label for="imagem_3">Imagem Extra 3:</label>
      <input type="file" id="imagem_3" name="imagem_3" accept="image/*">

      <label for="imagem_4">Imagem Extra 4:</label>
      <input type="file" id="imagem_4" name="imagem_4" accept="image/*">

      <label for="categoria">Categoria:</label>
      <select id="categoria" name="categoria" required>
        <option value="">Selecione...</option>
        <option value="quarto">Quarto</option>
        <option value="cozinha">Cozinha</option>
        <option value="sala_de_jantar">Sala de Jantar</option>
        <option value="escritorio">Escritório</option>
        <option value="sala_de_estar">Sala de Estar</option>
        <option value="eletrodomesticos">Eletrodomésticos</option>
      </select>


      <label for="subcategoria">Subcategoria:</label>
      <select id="subcategoria" name="subcategoria" required>
        <option value="">Selecione uma categoria primeiro</option>
      </select>

      <label><input type="checkbox" id="destaque" name="destaque"> Destaque</label>
      <label><input type="checkbox" id="mais_vendido" name="mais_vendido"> Mais Vendido</label>
      <label><input type="checkbox" id="indisponivel" name="indisponivel"> Indisponível</label>

      <button type="submit">Adicionar Produto</button>
    </form>
    <div class="voltar-container">
      <a href="/Catalog/admin" class="btn-voltar">← Voltar ao Painel</a>
    </div>


    <p id="mensagem"></p>

  </div>

  <script src="/Catalog/manager/js/add_product.js"></script>
  <script src="/Catalog/manager/js/script.js"></script>
</body>

</html>