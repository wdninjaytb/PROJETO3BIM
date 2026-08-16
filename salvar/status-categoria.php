<?php
if (!isset($page)) exit;

$id = $_POST["id"] ?? NULL;
$ativo = $_POST["ativo"] ?? NULL;

$sql = "update categoria set ativo = :ativo where id = :id";

$consulta = $pdo->prepare($sql);

$consulta->bindParam(":ativo", $ativo);
$consulta->bindParam(":id", $id);

$consulta->execute();