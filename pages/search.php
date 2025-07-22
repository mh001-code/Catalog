<?php
// Define o tipo de conteúdo
header('Content-Type: text/html; charset=utf-8');

// Inclui o arquivo de conexão
include '../php/conection.php'; // Ajuste o caminho se necessário

function slugify($text)
{
    $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    $text = preg_replace('/[\s-]+/', '-', $text);
    return trim($text, '-');
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Captura o termo de pesquisa vindo do formulário
    $pesquisa = $_GET['pesquisa'] ?? '';

    $resultados = [];

    if ($pesquisa) {
        $stmt = $pdo->prepare("SELECT * FROM produtos WHERE nome LIKE :pesquisa OR subcategoria LIKE :pesquisa");
        $stmt->execute(['pesquisa' => '%' . $pesquisa . '%']);
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados da Pesquisa</title>
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="icon" href="../img/icons/favicon1.png" type="image/x-icon">
</head>

<body>

    <div><?php include '../tools/header.html'; ?></div>
    <div><?php include '../tools/menu.html'; ?></div>

    <div>
        <h1>Resultados da Pesquisa</h1>

        <?php if (empty($resultados)) : ?>
            <h2>Nenhum produto encontrado para <strong><?= htmlspecialchars($pesquisa) ?></strong>.</h2>
        <?php else : ?>
            <div class="produtos-container">
                <?php foreach ($resultados as $produto) :
                    $valorParcela = number_format($produto['preco'] / 5, 2, ',', '.');
                    $slug = slugify($produto['nome']);
                ?>
                    <div class="product">
                        <?php if ($produto['indisponivel'] == 1): ?>
                            <img src="<?= htmlspecialchars($produto['imagem']) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>" class="img-indisponivel">
                            <h3><?= htmlspecialchars($produto['nome']) ?></h3>
                            <p class="preco"></p>
                            <p class="parcelamento"></p>
                            <br>
                            <span class="entrega_montagem"></span>
                            <br>
                            <p class="indisponivel-text">Produto Indisponível</p>
                            <br>
                            <button class="btn-ver-mais indisponivel" disabled>Indisponível</button>
                        <?php else: ?>
                            <img src="<?= htmlspecialchars($produto['imagem']) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>">
                            <h3><?= htmlspecialchars($produto['nome']) ?></h3>
                            <p class="preco">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>
                            <p class="parcelamento">em 5x de R$ <?= $valorParcela; ?> no cartão!</p>
                            <p class="crediario">Ou em até 12x no Crediário!</p>
                            <span class="entrega_montagem">Entrega e Montagem Grátis!</span>
                            <p class="indisponivel-text"></p>
                            <a href="/produto/<?= $produto['id']; ?>/<?= $slug ?>">
                                <button class="btn-ver-mais">Detalhes</button>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <div><?php include '../tools/footer.html'; ?></div>
    
    <script src="/js/products.js?v=<?= time() ?>"></script>
    <script src="/js/script.js?v=<?= time() ?>"></script>

</body>

</html>
