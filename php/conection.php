<?php
// Defina as configurações de conexão com o banco de dados
$host = 'localhost';
$dbname = 'u308712894_baby_di';
$user = 'u308712894_baby_di';
$password = '5u[MqR4Z';

try {
    $pdo = new PDO("mysql:host=$host;port=3306;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
}
