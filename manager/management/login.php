<?php
session_start();

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';

    $usuarioCorreto = 'admin';
    $senhaCorreta = 'senha123';

    if ($usuario === $usuarioCorreto && $senha === $senhaCorreta) {
        $_SESSION['logado'] = true;
        header('Location: admin');
        exit;
    } else {
        $erro = 'Usuário ou senha inválidos!';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="/Catalog/css/styles.css" />
</head>
<body>
    <div class="login-container">
        <form method="POST" class="login-form">
            <h2 class="login-title">Login do Administrador</h2>

            <div class="form-group">
                <input type="text" name="usuario" placeholder="Usuário" required class="form-input">
            </div>

            <div class="form-group">
                <input type="password" name="senha" placeholder="Senha" required class="form-input">
            </div>

            <button type="submit" class="btn-login">Entrar</button>

            <a href="/Catalog/Home" class="btn-voltar-home">← Voltar para o Catálogo</a>


            <?php if ($erro): ?>
                <div class="erro"><?= $erro ?></div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
