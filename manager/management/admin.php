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
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Painel do Catálogo</title>
    <link rel="stylesheet" href="/FurnitureCatalog/css/styles.css">
    <link rel="icon" href="/img/icons/favicon1.png" type="image/x-icon">
</head>
<body>
    <div class="admin-container">
        <h1>Painel de Gerenciamento</h1>

        <div class="admin-actions">
            <a href="/FurnitureCatalog/admin/adicionar">
                <span>➕</span> Adicionar Produto
            </a>
            <a href="/FurnitureCatalog/admin/editar">
                <span>✏️</span> Editar/Excluir Produto
            </a>
            <a href="/FurnitureCatalog/logout" class="logout-btn">
                <span>🔒</span> Sair
            </a>
        </div>
    </div>
</body>
</html>
