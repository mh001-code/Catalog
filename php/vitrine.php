<?php
// Incluindo o arquivo de conexão
include 'conection.php';

// Consulta para pegar os produtos destacados
try {
    $sql = "SELECT * FROM produtos WHERE destaque = 1 ORDER BY preco ASC"; // Consulta para produtos destacados
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $destaques = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Consulta para pegar os produtos mais vendidos
    $sqlMaisVendidos = "SELECT * FROM produtos WHERE mais_vendido = 1  ORDER BY preco ASC";
    $stmtMaisVendidos = $pdo->prepare($sqlMaisVendidos);
    $stmtMaisVendidos->execute();
    $maisVendidos = $stmtMaisVendidos->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo json_encode(['erro' => 'Erro ao buscar os produtos: ' . $e->getMessage()]);
    exit;
}
function slugify($text)
{
    // Remove acentos e caracteres especiais
    $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
    // Transforma em minúsculas
    $text = strtolower($text);
    // Remove caracteres indesejados
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    // Substitui espaços e hífens múltiplos por um único hífen
    $text = preg_replace('/[\s-]+/', '-', $text);
    // Remove hífens do início e fim
    $text = trim($text, '-');
    return $text;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baby-di Magazine</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>

    <!-- Seção de Destaques -->
    <section class="vitrine">
        <h2 class="vitrine-titulo">Novidades</h2>
        <div class="carousel-container">
            <button class="prev-btn">&#10094;</button>
            <div class="carousel">
                <?php foreach ($destaques as $produto) {
                    // Calculando o valor de parcelamento
                    $valorParcela = number_format($produto['preco'] / 5, 2, ',', '.');
                ?>
                    <div class="product">
                        <?php if ($produto['indisponivel'] == 1): ?>
                            <img src="<?= $produto['imagem']; ?>" alt="<?= $produto['nome']; ?>" class="img-indisponivel">
                            <h3><?= $produto['nome']; ?></h3>
                            <p class="preco"></p>
                            <p class="parcelamento"></p>
                            <br>
                            <span class="acrescimo"></span>
                            <br>
                            <p class="indisponivel-text">Produto Indisponível</p>
                            <br>
                            <button class="btn-ver-mais indisponivel" disabled>Indisponível</button>
                        <?php else: ?>
                            <img src="<?= $produto['imagem']; ?>" alt="<?= $produto['nome']; ?>">
                            <h3><?= $produto['nome']; ?></h3>
                            <p class="preco"><?= 'R$ ' . number_format($produto['preco'], 2, ',', '.'); ?></p>
                            <p class="parcelamento">ou em 5x de R$ <?= $valorParcela; ?></p>
                            <span class="acrescimo">Acima de 5x sujeito a acréscimo.</span>
                            <p class="crediario">Ou em até 12x no Crediário!</p>
                            <p class="indisponivel-text"></p>
                            <a href="/Catalog/produto/<?= $produto['id']; ?>/<?= slugify($produto['nome']); ?>">
                                <button class="btn-ver-mais">Detalhes</button>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php } ?>
            </div>
            <button class="next-btn">&#10095;</button>
        </div>

        <!-- Seção de Mais Vendidos -->
        <h2 class="vitrine-titulo">Os mais desejados</h2>
        <div class="carousel-container">
            <button class="prev-btn">&#10094;</button>
            <div class="carousel">
                <?php foreach ($maisVendidos as $produto) {
                    // Calculando o valor de parcelamento
                    $valorParcela = number_format($produto['preco'] / 5, 2, ',', '.');
                ?>
                    <div class="product">
                        <?php if ($produto['indisponivel'] == 1): ?>
                            <img src="<?= $produto['imagem']; ?>" alt="<?= $produto['nome']; ?>" class="img-indisponivel">
                            <h3><?= $produto['nome']; ?></h3>
                            <p class="preco"></p>
                            <p class="parcelamento"></p>
                            <br>
                            <span class="acrescimo"></span>
                            <br>
                            <p class="indisponivel-text">Produto Indisponível</p>
                            <br>
                            <button class="btn-ver-mais indisponivel" disabled>Indisponível</button>
                        <?php else: ?>
                            <img src="<?= $produto['imagem']; ?>" alt="<?= $produto['nome']; ?>">
                            <h3><?= $produto['nome']; ?></h3>
                            <p class="preco"><?= 'R$ ' . number_format($produto['preco'], 2, ',', '.'); ?></p>
                            <p class="parcelamento">ou em 5x de R$ <?= $valorParcela; ?></p>
                            <span class="acrescimo">Acima de 5x sujeito a acréscimo.</span>
                            <p class="crediario">Ou em até 12x no Crediário!</p>
                            <p class="indisponivel-text"></p>
                            <a href="/Catalog/produto/<?= $produto['id']; ?>/<?= slugify($produto['nome']); ?>">
                                <button class="btn-ver-mais">Detalhes</button>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php } ?>
            </div>
            <button class="next-btn">&#10095;</button>
        </div>
    </section>



    <script src="../js/script.js"></script>

</body>

</html>