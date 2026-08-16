<?php
if (!isset($page)) exit;


if (empty($id)) {
    echo "<script>mensagem('Estoque não informado', 'error');</script>";
    exit;
}

$pdo->beginTransaction();

$sqlDelete = "delete from estoque where id = :id limit 1";
$consultaDelete = $pdo->prepare($sqlDelete);
$consultaDelete->bindParam(":id", $id);

if ($consultaDelete->execute()) {
    $pdo->commit();
    echo "<script>mensagem('Registro Excluído', 'success', 'listar/estoque');</script>";
    exit;
} else {
    echo "<script>mensagem('Não foi possível excluir o estoque', 'error');</script>";
    exit;
}