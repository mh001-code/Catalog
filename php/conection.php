<?php
// Defina as configurações de conexão com o banco de dados
$host = 'localhost';
$dbname = 'gilmar_moveis';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;port=3306;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
}
