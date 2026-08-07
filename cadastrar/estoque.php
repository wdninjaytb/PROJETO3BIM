<?php
    
    if (!isset($page)) exit;
?>
<div class="container pt-5 pb-5">
<div class="card shadow">
    <div class="card-header">
        <div class="float-start">
            <h2>Cadastro de Estoque</h2>
        </div>
            <div class="float-end">
                <a href="cadastrar/estoque" class="btn btn-success">
                Novo Registro
                </a>
                <a href="listar/file" class="btn btn-success">
                Listar Registro
                </a>
            </div>
        </div>
        <div class="card-body">
            <form name="formCadastro" method="post" action="salvar/estoque" data-parsley-validate
            enctype="multipart/form-data">
            <div class="row">
                <div class="col-12 col-md-1">
                        <label for="id">ID:</label>
                        <input type="number" name="id" id="id" readonly class="form-control">
                </div>
                <div class="col-12 col-md-6">
                    <label for="nome">Nome do Produto:</label>
                    <input type="text" name="produto" id="produto" class="form-control" data-parsley-required-message="Preencha esse campo">
                </div>
                <div class="col-12 col-md-2">
                    <label for="qntd">Quantid. em Estoque:</label>
                    <input type="number" name="qntd" id="qntd" class="form-control" data-parsley-required-message="Preencha esse campo">
                </div>
                <div class="col-12 col-md-3 ">
                    <label for="categoria_id">Selecione a Categoria:</label>
                    <select type="number" name="categoria_id" id="categoria_id" class="form-control" required data-parsley-required-message="Selecione uma opção">
                        <option value="">Selecione</option>
                        <?php   
                            $sqlcategoria = "select id, categoria, from categoria
                                order by categoria";

                            $consultaCategoria = $pdo->prepare($sqlcategoria);
                            $consultaCategoria->execute();

                            $dadosCategoria = $consultaCategoria->fetchAll(PDO::FETCH_OBJ);

                            foreach($dadosCategoria as $dados) {
                            ?>
                            <option value="<?= $dados->id ?>"><?= $dados->categoria ?></option>
                            <?php
                            }
                        ?>
                    </select>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>