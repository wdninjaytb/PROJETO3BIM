<?php
if (!isset($page)) exit;

if (!empty($id)) {
    $sql = "select * from produto where id = :id limit 1";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(":id", $id);
    $consulta->execute();

    $dados = $consulta->fetch(PDO::FETCH_OBJ);
}

    $categoria_id = $dados->categoria_id ?? NULL;
    $nome = $dados->nome ?? NULL;
    $descricao = $dados->descricao ?? NULL;
    $preco = $dados->preco ?? NULL;
    $marca = $dados->marca ?? NULL;
?>

<div class="container">
    <div class="card shadow admin-card">

        <div class="card-header d-flex justify-content-between align-items-center">
                <h2>Cadastro de Produto</h2>

            <div class="d-flex gap-2">
                <a href="cadastrar/produto" class="btn btn-success">
                    Novo Registro
                </a>

                <a href="listar/produto" class="btn btn-success">
                    Listar Registro
                </a>
            </div>
        </div>

        <div class="card-body">

            <form name="formCadastro" method="post" action="salvar/produto" data-parsley-validate enctype="multipart/form-data">

                <div class="row">

                    <div class="col-12 col-md-1">
                        <label for="id">ID:</label>
                        <input type="number" name="id" id="id" readonly class="form-control" data-parsley-required-message="Preencha esse campo" value="<?= $id ?>">
                    </div>

                    <div class="col-12 col-md-6">
                    <label for="nome">Nome do Produto:</label>
                    <input type="text" name="nome" id="nome" class="form-control" required value="<?= $nome ?>" data-parsley-required-message="Preencha esse campo">
                    </div>
                    
                    <div class="col-12 col-md-3">
                        <label for="categoria_id">Categoria:</label>

                        <select name="categoria_id" id="categoria_id" class="form-control" required data-parsley-required-message="Selecione uma categoria">

                            <option value="">Selecione</option>

                            <?php
                            $sqlCategoria = "select id, nome from categoria where ativo = true order by nome";

                            $consultaCategoria = $pdo->prepare($sqlCategoria);
                            $consultaCategoria->execute();

                            $dadosCategorias = $consultaCategoria->fetchAll(PDO::FETCH_OBJ);

                            foreach ($dadosCategorias as $categoria) {
                            ?>

                                <option value="<?= $categoria->id ?>">
                                    <?= $categoria->nome ?>
                                </option>

                            <?php
                            }
                            ?>

                        </select>
                        <script>
                            $(document).ready(function() {
                                $("#categoria_id").val(<?= $categoria_id ?>);
                            })
                        </script>
                    </div>

                    <div class="col-12 col-md-2">
                        <label for="preco">Preço do Produto:</label>
                        <input type="number" name="preco" id="preco" class="form-control" value="<?= $preco ?>" step="0.01" min="0" required data-parsley-required-message="Preencha esse campo" data-parsley-min-message="O preço não pode ser negativo">
                    </div>


                    <div class="col-7 col-md-5">
                        <label for="img">Imagem do Produto:</label>
                        <input type="file" name="img" id="img" class="form-control">
                    </div>

                    <div class="col-7 col-md-2">
                    <label for="marca">Marca do Produto:</label>
                    <input type="text" name="marca" id="marca" class="form-control" required value="<?= $marca ?>" required data-parsley-required-message="Preencha esse campo">
                    </div>

                    <div class="col-12 col-md-12">
                        <label for="descricao">Descrição do Produto:</label>
                        <textarea name="descricao" id="descricao" class="form-control" value="" data-parsley-required-message="Preencha esse campo"><?= $descricao ?></textarea>
                    </div>

        </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-success float-end">
                        Salvar
                    </button>
                </div>



            </form>

        </div>
    </div>
</div>  

<script>
    $(document).ready(function() {
        $('#descricao').summernote({
            placeholder: 'Digite a descrição do Produto',
            tabsize: 2,
            height: 100
        });
    });
</script>