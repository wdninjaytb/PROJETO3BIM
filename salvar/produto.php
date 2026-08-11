<?php
    if (!isset($page)) exit;

    if ($_POST) {
        $id = trim( $_POST["id"] ?? NULL);
        $nome = trim( $_POST["nome"] ?? NULL);
        $categoria_id = trim( $_POST["categoria_id"] ?? NULL);
        $preco = trim( $_POST["preco"] ?? NULL);
        $descricao = trim( $_POST["descricao"] ?? NULL);
        $marca = trim( $_POST["marca"] ?? NULL);

        $arquivo = $_SESSION["kaeru"]["id"] . "_" . time();

        if ((!empty($_FILES["img"]["name"])) && (!move_uploaded_file($_FILES["img"]["tmp_name"], "./arquivos/{$arquivo}.jpg"))) {

            echo "<script>mensagem('Falha ao enviar arquivo', 'error');</script>";
            exit;

        }

        if (!empty($_FILES["img"]["name"])) {
            $origem = "./arquivos/{$arquivo}.jpg";
            redimensionarImagem($origem, 600, 800, 100);
        }

        if (empty($id)) {
             if (empty($_FILES["img"]["name"])) {
                echo "<script>mensagem('Selecione um arquivo','error');</script>'";
             }

            $sqlCadastro = "insert into produto (categoria_id, nome, descricao, preco, marca, img) values (:categoria_id, :nome, :descricao, :preco, :marca, :img)";
            $consultaCadastro = $pdo->prepare($sqlCadastro);
            $consultaCadastro-> bindParam(":categoria_id", $categoria_id);
            $consultaCadastro-> bindParam(":nome", $nome);
            $consultaCadastro-> bindParam(":descricao", $descricao);
            $consultaCadastro-> bindParam(":preco", $preco);
            $consultaCadastro-> bindParam(":marca", $marca);
            $consultaCadastro-> bindParam(":img", $arquivo);
        } else if (empty($_FILES["img"]["name"])){
            $sqlCadastro = "update produto set categoria_id = :categoria_id, nome = :nome, descricao = :descricao, preco = :preco, marca = :marca where id = :id limit 1";
            $consultaCadastro = $pdo->prepare($sqlCadastro);
            $consultaCadastro-> bindParam(":categoria_id", $categoria_id);
            $consultaCadastro-> bindParam(":nome", $nome);
            $consultaCadastro-> bindParam(":descricao", $descricao);
            $consultaCadastro-> bindParam(":preco", $preco);
            $consultaCadastro-> bindParam(":marca", $marca);
            $consultaCadastro-> bindParam(":id", $id);
            
        } else {
            $sqlCadastro = "update produto set categoria_id = :categoria_id, nome = :nome, descricao = :descricao, preco = :preco, marca = :marca, img = :img where id = :id limit 1";
            $consultaCadastro = $pdo->prepare($sqlCadastro);
            $consultaCadastro-> bindParam(":categoria_id", $categoria_id);
            $consultaCadastro-> bindParam(":nome", $nome);
            $consultaCadastro-> bindParam(":descricao", $descricao);
            $consultaCadastro-> bindParam(":preco", $preco);
            $consultaCadastro-> bindParam(":marca", $marca);
            $consultaCadastro-> bindParam(":id", $id);
            $consultaCadastro-> bindParam(":img", $arquivo);
        }

        if ($consultaCadastro->execute()) {
            echo "<script>mensagem('Registro salvo com sucesso', 'success', 'listar/produto');</script>";
            exit;
        }

    } else {
        echo "<script>mensagem('Requisição inválida', 'error');</script>";
        exit;
    }