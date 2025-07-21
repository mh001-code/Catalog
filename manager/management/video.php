<?php
session_start();
if (!isset($_SESSION['logado'])) {
    header('Location: login');
    exit;
}

$configPath = __DIR__ . '/../config/video_config.json';
$videoDir = __DIR__ . '/../videos/';
$config = json_decode(file_get_contents($configPath), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Envio do vídeo
    if (isset($_FILES['video']) && $_FILES['video']['error'] === 0) {
        $ext = pathinfo($_FILES['video']['name'], PATHINFO_EXTENSION);
        $novoNome = 'promocao.' . $ext;
        $destino = $videoDir . $novoNome;

        if (move_uploaded_file($_FILES['video']['tmp_name'], $destino)) {
            $config['arquivo'] = $novoNome;
            $mensagem = "Vídeo enviado com sucesso!";
        } else {
            $mensagem = "Erro ao enviar vídeo.";
        }
    }

    // Visibilidade
    if (isset($_POST['visivel'])) {
        $config['visivel'] = $_POST['visivel'] === '1';
    }

    // Remover vídeo
    if (isset($_POST['remover']) && !empty($config['arquivo'])) {
        $arquivo = $videoDir . $config['arquivo'];
        if (file_exists($arquivo)) unlink($arquivo);
        $config['arquivo'] = '';
        $config['visivel'] = false;
        $mensagem = "Vídeo removido com sucesso.";
    }

    // Salva atualizações
    file_put_contents($configPath, json_encode($config));
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gerenciar Vídeo Promocional</title>
    <link rel="stylesheet" href="/Catalog/css/styles.css">
</head>

<body>
    <div class="admin-container">
        <h2>Gerenciar Vídeo Promocional</h2>

        <?php if (!empty($config['arquivo']) && file_exists($videoDir . $config['arquivo'])): ?>
            <video controls style="width: 100%; margin-top: 20px;">
                <source src="/Catalog/manager/videos/<?= htmlspecialchars($config['arquivo']) ?>?v=<?= filemtime($videoDir . $config['arquivo']) ?>" type="video/mp4">
            </video>
        <?php else: ?>
            <p style="margin-top: 20px;">Nenhum vídeo enviado.</p>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <label for="video">Enviar novo vídeo:</label>
            <input type="file" name="video" accept="video/mp4">

            <label for="visivel">Visibilidade do vídeo:</label>
            <select name="visivel">
                <option value="1" <?= $config['visivel'] ? 'selected' : '' ?>>Visível</option>
                <option value="0" <?= !$config['visivel'] ? 'selected' : '' ?>>Oculto</option>
            </select>

            <button type="submit">Salvar alterações</button>
        </form>

        <?php if (!empty($config['arquivo'])): ?>
            <form method="POST">
                <input type="hidden" name="remover" value="1">
                <button type="submit" style="background-color:#d9534f;">Remover vídeo</button>
            </form>
        <?php endif; ?>

        <div class="voltar-container">
            <a href="/Catalog/admin" class="btn-voltar">← Voltar ao Painel</a>
        </div>

        <?php if (!empty($mensagem)): ?>
            <div id="mensagem"><?= htmlspecialchars($mensagem) ?></div>
        <?php endif; ?>
    </div>

</body>

<script>
    window.addEventListener("DOMContentLoaded", () => {
        const msg = document.getElementById("mensagem");
        if (msg) {
            setTimeout(() => {
                msg.classList.add("fade-out");
            }, 3000); // Espera 3 segundos antes de começar a desaparecer

            setTimeout(() => {
                msg.style.display = "none";
            }, 4500); // Remove da tela após o fade
        }
    });
</script>

</html>