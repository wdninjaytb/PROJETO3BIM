<?php
if (!isset($page)) exit;


if (empty($id)) {
    echo "<script>mensagem('Produto não informado', 'error');</script>";
    exit;
}

$pdo->beginTransaction();

$sqlProduto = "select id from estoque where produto_id = :id limit 1";
$consultaProduto = $pdo->prepare($sqlProduto);
$consultaProduto->bindParam(":id", $id);
$consultaProduto->execute();

$dadosProduto = $consultaProduto->fetch(PDO::FETCH_OBJ);

if (!empty($dadosProduto->id)) {
    $pdo->rollBack();
    echo "<script>mensagem('Não foi possível excluir, pois temos estoque desse produto cadastrado', 'error', 'listar/produto');</script>";
    exit;
}

$sqlDelete = "delete from produto where id = :id limit 1";
$consultaDelete = $pdo->prepare($sqlDelete);
$consultaDelete->bindParam(":id", $id);

if ($consultaDelete->execute()) {
    $pdo->commit();
    echo "<script>mensagem('Registro Excluído', 'success', 'listar/produto');</script>";
    exit;
} else {
    echo "<script>mensagem('Não foi possível excluir o produto', 'error','listar/produto');</script>";
    $pdo->rollBack();
    exit;
}