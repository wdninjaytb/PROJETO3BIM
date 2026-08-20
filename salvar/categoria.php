<?php
    if (!isset($page)) exit;

    if ($_POST) {
        $id = trim( $_POST["id"] ?? NULL);
        $nome = trim( $_POST["nome"] ?? NULL);
        $descricao = trim( $_POST["descricao"] ?? NULL);

        if (empty($nome)) {
            echo "<script>mensagem('Preencha o nome da categoria', 'error');</script>";
            exit;
        }

        if (empty($descricao)) {
        echo "<script>mensagem('Preencha a descrição da categoria', 'error');</script>";
        exit;
        }

        if (empty($id)) {
            $sqlVerificar = "select id from categoria where nome = :nome limit 1";

            $consultaVerificar = $pdo->prepare($sqlVerificar);
            $consultaVerificar->bindParam(":nome", $nome);
            $consultaVerificar->execute();
        } else {
            $sqlVerificar = "select id from categoria where nome = :nome and id != :id limit 1";

            $consultaVerificar = $pdo->prepare($sqlVerificar);
            $consultaVerificar->bindParam(":nome", $nome);
            $consultaVerificar->bindParam(":id", $id);
            $consultaVerificar->execute();
        }

        $categoriaExistente = $consultaVerificar->fetch(PDO::FETCH_OBJ);

        if ($categoriaExistente) {
            echo "<script>mensagem('Já existe uma categoria com esse nome', 'error', 'listar/categoria');</script>";
            exit;
        }

        if (empty($id)) {

            $sqlCadastro = "insert into categoria (nome, descricao ) values (:nome, :descricao)";
            
            $consultaCadastro = $pdo->prepare($sqlCadastro);

            $consultaCadastro-> bindParam(":nome", $nome);
            $consultaCadastro-> bindParam(":descricao", $descricao);
        } else {
            $sqlCadastro = "update categoria set nome = :nome, descricao = :descricao where id = :id limit 1";
            $consultaCadastro = $pdo->prepare($sqlCadastro);
            $consultaCadastro-> bindParam(":nome", $nome);
            $consultaCadastro-> bindParam(":descricao", $descricao);
            $consultaCadastro->bindParam(":id", $id);
            
        }

        if ($consultaCadastro->execute()) {
            echo "<script>mensagem('Registro salvo com sucesso', 'success', 'listar/categoria');</script>";
            exit;
        }

    } else {
        echo "<script>mensagem('Requisição inválida', 'error');</script>";
        exit;
    }