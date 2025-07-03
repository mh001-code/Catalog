<!-- detalhes_produto.html -->
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Baby-di Móveis</title>
    <link rel="stylesheet" href="/Catalog/css/styles.css">
    <link rel="icon" href="/Catalog/img/icons/favicon1.png" type="image/x-icon">
</head>

<body>

<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);?>


    <div>
        <?php include '../tools/header.html'; ?>
    </div>

    <div class="clear"></div>

    <?php include '../tools/menu.html'; ?>

    <div class="produto-detalhe">
        <div id="navegacao-categorias"></div> <!-- Aqui entram os links -->
        <h1 id="nome-produto"></h1>

        <div class="imagem-e-preco">
            <div class="galeria-imagens">
                <img id="imagem-principal" src="" alt="">
                <!-- Modal para zoom da imagem -->
                <div id="zoomModal" class="modal" onclick="fecharZoom(event)">
                    <span class="fechar-btn" onclick="fecharZoom(event)">✕</span>
                    <img id="imagemZoomada" class="imagem-zoomada" src="" alt="">
                </div>

                <div class="miniaturas"></div>
            </div>


            <div class="preco-e-aviso">
                <p id="preco-produto"></p>
                <p id="aviso-parcelamento" class="aviso-parcelamento"></p>
                <p id="crediario" class="crediario"></p>
            </div>
        </div>

        <div id="crediario-link" class="crediario-link"></div>
        <div id="whatsapp-link" class="whatsapp-link"></div>


        <p id="descricao-produto"></p>

    </div>

    <div>
        <?php include '../tools/footer.html'; ?>
    </div>

    <script src="/Catalog/js/product.js"></script>
    <script src="/Catalog/js/script.js"></script>
</body>

</html>