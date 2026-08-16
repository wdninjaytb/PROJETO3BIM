<?php
if (!isset($page)) exit;
?>

<div class="container pt-5 pb-5 mt-5">
    <div class="card shadow">

        <div class="card-header">
            <div class="float-start">
                <h2>Listagem de Categorias</h2>
            </div>

            <div class="float-end">
                <a href="cadastrar/categoria" class="btn btn-success">
                    Novo Registro
                </a>

                <a href="listar/categoria" class="btn btn-success">
                    Listar Registro
                </a>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <td>ID da Categoria</td>
                        <td>Nome da Categoria</td>
                        <td>Descricao da Categoria</td>
                        <td>Status</td>
                        <td>Opções</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sqlListar = "select id, nome, descricao, ativo from categoria order by nome";
                        $consultaListar = $pdo->prepare($sqlListar);
                        $consultaListar->execute();

                        $dadosListar = $consultaListar->fetchAll(PDO::FETCH_OBJ);

                        foreach ($dadosListar as $dados) {
                            ?>
                            <tr>
                                <td><?= $dados->id ?></td>
                                <td><?= $dados->nome ?></td>
                                <td><?= $dados->descricao ?></td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" data-id="<?= $dados->id ?>" <?= $dados->ativo == 1 ? "checked" : "" ?>>
                                    </div>
                                </td>

                                <td>
                                    <a href="cadastrar/categoria/<?= $dados->id ?>" class="btn btn-success">
                                        Editar
                                    </a>
                                    <a href="javascript:excluir(<?= $dados->id ?>)" class="btn btn-danger">
                                        Excluir
                                    </a>
                                </td>
                            </tr>
                            <?php
                        }
                    ?>
                </tbody>
            </table>
            <script>
                const switches = document.querySelectorAll(".form-check-input");

                switches.forEach(function(switchCategoria) {
                    switchCategoria.addEventListener("change", function() {

                        const id = switchCategoria.dataset.id;
                        const ativo = switchCategoria.checked ? 1 : 0;

                        console.log("ID: ", id);
                        console.log("ATIVO ENVIADO: ", ativo);
                        
                        fetch("salvar/status-categoria", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/x-www-form-urlencoded"
                            },
                            body: `id=${id}&ativo=${ativo}`
                        })

                    });
                });
            
                function excluir(id) {

                    Swal.fire({
                    title: "Deseja realmente excluir?",
                    text: "Essa ação não poderá ser desfeita.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Excluir",
                    cancelButtonText: "Cancelar"

                }).then((resultado) => {

                    if (resultado.isConfirmed) {
                        location.href = `excluir/categoria/${id}`;
                    }

                });
            }

            </script>
        </div>
    </div>
</div>

