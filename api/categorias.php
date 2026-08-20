<?php

header('Content-Type: application/json; charset=utf-8');

$conn = new PDO(
    "mysql:host=localhost;dbname=kaeru-admin",
    "root",
    ""
);

$sql = "select * from categoria";

$stmt = $conn->prepare($sql);

$stmt->execute();

$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($categorias);