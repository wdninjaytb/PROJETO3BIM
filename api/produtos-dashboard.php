<?php

    header('Content-Type: application/json; charset=utf-8');

    $conn = new PDO(
    "mysql:host=localhost;dbname=kaeru-admin",
    "root",
    ""
    );

    $categoria = $_GET["categoria"] ?? null;
    $busca = $_GET["busca"] ?? null;
    $limite = $_GET["limite"] ?? 5;
    $offset = $_GET["offset"] ?? 0;

    $limite = (int) $limite;
    $offset = (int) $offset;

    if ($categoria !== null) {
        $categoria = (int) $categoria;
    }

    $sql = "call buscar_produtos_dashboard(:categoria, :busca, :limite, :offset)";

    $stmt = $conn->prepare($sql);
    
    $stmt->bindValue(":categoria", $categoria);
    $stmt->bindValue(":busca", $busca);
    $stmt->bindValue(":limite", $limite, PDO::PARAM_INT);
    $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);

    $stmt->execute();

    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($produtos);