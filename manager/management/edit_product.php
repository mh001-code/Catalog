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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Editar Produto</title>
    <link rel="stylesheet" href="/Catalog/css/styles.css" />
</head>

<body>
    <div class="admin-container">
        <h2>Editar Produto</h2>
        <form id="buscar-form">
            <label for="busca-nome">Nome do Produto:</label>
            <input type="text" id="busca-nome" required />
        </form>

        <ul id="sugestoes" style="list-style: none; padding: 0;"></ul>

        <form id="editar-form" style="display:none;">
            <input type="hidden" id="id" />

            <label for="nome">Nome:</label>
            <input type="text" id="nome" required />

            <label for="preco">Preço:</label>
            <input type="number" step="0.01" id="preco" required />

            <label for="descricao">Descrição:</label>
            <textarea id="descricao" required></textarea>

            <!-- Imagem Principal -->
            <label>Imagem principal:</label>
            <input type="file" id="upload-imagem">
            <input type="hidden" id="imagem">
            <img id="preview-imagem" style="max-width: 150px; margin-top: 5px; display: none;">
            <label><input type="checkbox" id="remover-imagem"> Remover imagem</label>


            <label>Imagem 2:</label>
            <input type="file" id="upload-imagem_2">
            <input type="hidden" id="imagem_2">
            <img id="preview-imagem_2" style="max-width: 150px; margin-top: 5px; display: none;">
            <label><input type="checkbox" id="remover-imagem_2"> Remover imagem</label>


            <label>Imagem 3:</label>
            <input type="file" id="upload-imagem_3">
            <input type="hidden" id="imagem_3">
            <img id="preview-imagem_3" style="max-width: 150px; margin-top: 5px; display: none;">
            <label><input type="checkbox" id="remover-imagem_2"> Remover imagem</label>


            <label>Imagem 4:</label>
            <input type="file" id="upload-imagem_4">
            <input type="hidden" id="imagem_4">
            <img id="preview-imagem_4" style="max-width: 150px; margin-top: 5px; display: none;">
            <label><input type="checkbox" id="remover-imagem_2"> Remover imagem</label>


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
            <option value="">Selecione uma categoria primeiro</option>
            </select>
            <label><input type="checkbox" id="destaque" /> Destaque</label>
            <label><input type="checkbox" id="mais_vendido" /> Mais Vendido</label>
            <label><input type="checkbox" id="indisponivel" /> Indisponível</label>

            <button type="submit">Salvar Alterações</button>

            <button type="button" id="btn-excluir" style="background-color: red; color: white; margin-top: 10px;">
                Excluir Produto
            </button>
        </form>

        <div class="voltar-container">
            <a href="/Catalog/admin" class="btn-voltar">← Voltar ao Painel</a>
        </div>


        <p id="mensagem"></p>
    </div>
    <script src="/Catalog/manager/js/edit_product.js"></script>
    <script src="/Catalog/manager/js/script.js"></script>
</body>

</html>