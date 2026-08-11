<?php
if (!isset($page)) exit;
?>

<div class="container pt-5 pb-5 mt-5">
    <div class="card shadow">

        <div class="card-header">
            <div class="float-start">
                <h2>Cadastro de Estoque</h2>
            </div>

            <div class="float-end">
                <a href="cadastrar/estoque" class="btn btn-success">
                    Novo Registro
                </a>

                <a href="listar/estoque" class="btn btn-success">
                    Listar Registro
                </a>
            </div>
        </div>

        <div class="card-body">
        
            <form name="formCadastro" method="post" action="salvar/estoque" data-parsley-validate enctype="multipart/form-data">

                <div class="row">

                    <div class="col-12 col-md-1">
                        <label for="id">ID:</label>
                        <input type="number" name="id" id="id" readonly class="form-control">
                    </div>

                    <div class="col-12 col-md-5">
                        <label for="produto_id">Produto:</label>

                        <select name="produto_id" id="produto_id" class="form-control" required data-parsley-required-message="Selecione um produto">

                            <option value="">Selecione</option>

                            <?php
                            $sqlProduto = "select id, nome
                                           from produto
                                           order by nome";

                            $consultaProduto = $pdo->prepare($sqlProduto);
                            $consultaProduto->execute();

                            $dadosProdutos = $consultaProduto->fetchAll(PDO::FETCH_OBJ);

                            foreach ($dadosProdutos as $produto) {
                            ?>

                                <option value="<?= $produto->id ?>">
                                    <?= $produto->nome ?>
                                </option>

                            <?php
                            }
                            ?>

                        </select>

                    </div>
                    

                    <div class="col-12 col-md-3">
                        <label for="qntd">Quantidade em Estoque:</label>

                        <input type="number" name="qntd" id="qntd" class="form-control" min="0" required data-parsley-required-message="Preencha esse campo">
                    </div>

                </div>


             <div class="row mt-3">
                <div class="col-12">
                    <button type="submit" class="btn btn-success">
                        Salvar
                    </button>
            </div>
</div>
            </form>

        </div>
    </div>
</div>  