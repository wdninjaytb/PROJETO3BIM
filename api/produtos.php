<?php

header('Content-Type: application/json; charset=utf-8');

$conn = new PDO(
    "mysql:host=localhost;dbname=kaeru-admin",
    "root",
    ""
);

$sql = "select * from produto";

$stmt = $conn->prepare($sql);

$stmt->execute();

$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($produtos);