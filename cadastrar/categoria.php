<?php
if (!isset($page)) exit;

$dadosCategoria = null;

if (!empty($id)) {

    $sqlCategoria = "select id, nome, descricao from categoria where id = :id limit 1";

    $consultaCategoria = $pdo->prepare($sqlCategoria);
    $consultaCategoria->bindParam(":id", $id);
    $consultaCategoria->execute();

    $dadosCategoria = $consultaCategoria->fetch(PDO::FETCH_OBJ);
}
?>

<div class="container">
    <div class="card shadow admin-card">

        <div class="card-header d-flex justify-content-between align-items-center">
                <h2>Cadastro de Categoria</h2>

            <div class="d-flex gap-2">
                <a href="cadastrar/categoria" class="btn btn-success">
                    Novo Registro
                </a>

                <a href="listar/categoria" class="btn btn-success">
                    Listar Registro
                </a>
            </div>
        </div>

        <div class="card-body">

            <form name="formCadastro" method="post" action="salvar/categoria" data-parsley-validate enctype="multipart/form-data">

                <div class="row">

                    <div class="col-12 col-md-1">
                        <label for="id">ID:</label>
                        <input type="number" name="id" id="id" readonly class="form-control" data-parsley-required-message="Preencha esse campo" value="<?= $dadosCategoria->id ?? "" ?>">
                    </div>

                    <div class="col-12 col-md-6">
                    <label for="nome">Nome da Categoria:</label>
                    <input type="text" name="nome" id="nome" class="form-control" required data-parsley-required-message="Preencha esse campo" value="<?= $dadosCategoria->nome ?? "" ?>">
                    </div>

                    </div>

                    <div class="col-12 col-md-12">
                        <label for="descricao">Descrição da Categoria:</label>
                        <textarea name="descricao" id="descricao" class="form-control" required data-parsley-required-message="Preencha esse campo"><?= $dadosCategoria->descricao ?? "" ?></textarea>
                    </div>

                <div class="row mt-4">
                    <div class="col-12 d-flex justify-content-end pe-4">
                        <button type="submit" class="btn btn-success px-4">
                            Salvar
                    </button>
                </div>
            </div>
          </form>
        </div>
    </div>
</div>  

<script>
    $(document).ready(function() {
        $('#descricao').summernote({
            placeholder: 'Digite a descrição da Categoria',
            tabsize: 2,
            height: 100
        });
    });
</script>