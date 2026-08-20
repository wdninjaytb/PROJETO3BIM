<?php
    if (!isset($page)) exit;

    if ($_POST) {
        $id = trim( $_POST["id"] ?? NULL);
        $nome = trim( $_POST["nome"] ?? NULL);
        $categoria_id = trim( $_POST["categoria_id"] ?? NULL);
        $preco = trim( $_POST["preco"] ?? NULL);
        $descricao = trim( $_POST["descricao"] ?? NULL);
        $marca = trim( $_POST["marca"] ?? NULL);

        $arquivo = null;

        if (!empty($_FILES["img"]["name"])) {

            $nomeArquivo = $_SESSION["kaeru"]["id"] . "_" . time();
            $destino = "./arquivos/{$nomeArquivo}.jpg";

            if (!move_uploaded_file($_FILES["img"]["tmp_name"], $destino)) {
                echo "<script>mensagem('Falha ao enviar arquivo', 'error')</script>";
                exit;
            }

            redimensionarImagem($destino, 600, 800, 100);
            $arquivo = "{$nomeArquivo}.jpg";
        }

        if (empty($id)) {
            $sqlVerificar = "select id from produto where nome = :nome limit 1";

            $consultaVerificar = $pdo->prepare($sqlVerificar);
            $consultaVerificar->bindParam(":nome", $nome);
            $consultaVerificar->execute();
        } else {
            $sqlVerificar = "select id from produto where nome = :nome and id != :id limit 1";

            $consultaVerificar = $pdo->prepare($sqlVerificar);
            $consultaVerificar->bindParam(":nome", $nome);
            $consultaVerificar->bindParam(":id", $id);
            $consultaVerificar->execute();
        }

        $produtoExistente = $consultaVerificar->fetch(PDO::FETCH_OBJ);

        if ($produtoExistente) {
            echo "<script>mensagem('Já existe um produto com esse nome', 'error', 'listar/produto');</script>";
            exit;
        }

        if (empty($id)) {

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