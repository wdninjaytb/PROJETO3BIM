<?php
if (!isset($page)) exit;


if (empty($id)) {
    echo "<script>mensagem('Categoria não informada', 'error');</script>";
    exit;
}

$pdo->beginTransaction();

$sqlCategoria = "select id from produto where categoria_id = :id limit 1";
$consultaCategoria = $pdo->prepare($sqlCategoria);
$consultaCategoria->bindParam(":id", $id);
$consultaCategoria->execute();

$dadosCategoria = $consultaCategoria->fetch(PDO::FETCH_OBJ);

if (!empty($dadosCategoria->id)) {
    echo "<script>mensagem('Não foi possível excluir, pois temos produtos cadastrados nessa categoria', 'error', 'listar/categoria');</script>";
    $pdo->rollBack();
    exit;
}

$sqlDelete = "delete from categoria where id = :id limit 1";
$consultaDelete = $pdo->prepare($sqlDelete);
$consultaDelete->bindParam(":id", $id);

if ($consultaDelete->execute()) {
    $pdo->commit();
    echo "<script>mensagem('Registro Excluído', 'success', 'listar/categoria');</script>";
    exit;
} else {
    echo "<script>mensagem('Não foi possível excluir a categoria', 'error', 'listar/categoria');</script>";
    $pdo->rollBack();
    exit;
}