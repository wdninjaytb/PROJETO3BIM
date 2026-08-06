<?php
    $host = "localhost";
    $db = "kaeru-admin";
    $user = "root";
    $pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
} catch(PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}