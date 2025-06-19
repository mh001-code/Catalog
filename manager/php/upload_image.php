<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

// Caminho absoluto da pasta de destino
$targetDir = $_SERVER['DOCUMENT_ROOT'] . '/Catalog/img/product_images/';

// Cria a pasta se não existir
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0755, true);
}

// Verifica se o arquivo foi enviado
if (!isset($_FILES['imagem'])) {
    echo json_encode(['success' => false, 'message' => 'Nenhuma imagem enviada.']);
    exit;
}

$file = $_FILES['imagem'];
$fileName = $file['name'];
$fileTmpName = $file['tmp_name'];
$fileSize = $file['size'];
$fileError = $file['error'];

// Validação básica
if ($fileError !== 0) {
    echo json_encode(['success' => false, 'message' => 'Erro no upload da imagem.']);
    exit;
}

// Extensões permitidas
$allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
$fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

if (!in_array($fileExt, $allowedExt)) {
    echo json_encode(['success' => false, 'message' => 'Tipo de arquivo não permitido.']);
    exit;
}

// Gera nome único para a imagem
$uniqueName = md5(uniqid('', true)) . '.' . $fileExt;
$targetFilePath = $targetDir . $uniqueName;

// Move o arquivo para o diretório correto
if (move_uploaded_file($fileTmpName, $targetFilePath)) {
    // Caminho relativo para salvar no banco e usar no site
    $relativePath = '/Catalog/img/product_images/' . $uniqueName;
    echo json_encode(['success' => true, 'filename' => $relativePath]);
} else {
    echo json_encode(['success' => false, 'message' => 'Falha ao salvar a imagem.']);
}
