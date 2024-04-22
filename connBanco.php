<?php 
// Conexão com o banco de dados
$host = 'localhost';
$db_name = 'anestesicos';
$username = 'root';
$password = 'admin1234';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $erro) {
    echo 'Erro de conexão com o banco de dados: ' . $erro->getMessage();
    exit;
}