<?php
if (!isset($page)) exit;
?>

<div class="container pt-5 pb-5 mt-5">
    <div class="card shadow">

        <div class="card-header">
            <div class="float-start">
                <h2>Cadastro de Categoria</h2>
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

            <form name="formCadastro" method="post" action="salvar/produto" data-parsley-validate enctype="multipart/form-data">

                <div class="row">

                    <div class="col-12 col-md-1">
                        <label for="id">ID:</label>
                        <input type="number" name="id" id="id" readonly class="form-control" data-parsley-required-message="Preencha esse campo">
                    </div>

                    <div class="col-12 col-md-6">
                    <label for="nome">Nome da Categoria:</label>
                    <input type="text" name="nome" id="nome" class="form-control" data-parsley-required-message="Preencha esse campo">
                    </div>

                    </div>

                    <div class="col-12 col-md-12">
                        <label for="descricao">Descrição da Categoria:</label>
                        <textarea name="descricao" id="descricao" class="form-control" data-parsley-required-message="Preencha esse campo"></textarea>
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
            placeholder: 'Digite a descrição da Categoria',
            tabsize: 2,
            height: 100
        });
    });
</script>