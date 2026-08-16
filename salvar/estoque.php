<?php
    if (!isset($page)) exit;

    if ($_POST) {
        $id = trim( $_POST["id"] ?? NULL);
        $produto_id = trim( $_POST["produto_id"] ?? NULL);
        $qntd = trim( $_POST["qntd"] ?? NULL);

        if (empty($produto_id)) {
            echo "<script>mensagem('Selecione um produto', 'error');</script>";
            exit;
        }

        if ($qntd === "" || $qntd === NULL) {
            echo "<script>mensagem('Informe a quantidade', 'error');</script>";
            exit;
        }

        if ($qntd < 0) {
            echo "<script>mensagem('A quantidade não pode ser negativa', 'error');</script>";
            exit;
        }


        if (empty($id)) {


            $sqlCadastro = "insert into estoque (produto_id, quantidade) values (:produto_id, :quantidade)";
            $consultaCadastro = $pdo->prepare($sqlCadastro);

            $consultaCadastro-> bindParam(":produto_id", $produto_id);
            $consultaCadastro-> bindParam(":quantidade", $qntd);
            
        } else {
            $sqlCadastro = "update estoque set produto_id = :produto_id, quantidade = :quantidade where id = :id limit 1";
            $consultaCadastro = $pdo->prepare($sqlCadastro);

            $consultaCadastro-> bindParam(":produto_id", $produto_id);
            $consultaCadastro-> bindParam(":quantidade", $qntd);
            $consultaCadastro->bindParam(":id", $id);
        }

        if ($consultaCadastro->execute()) {
            echo "<script>mensagem('Registro salvo com sucesso', 'success', 'listar/estoque');</script>";
            exit;
        }

    } else {
        echo "<script>mensagem('Requisição inválida', 'error');</script>";
        exit;
    }