<?php
if (!isset($page)) exit;
?>

<div class="container pt-5 pb-5 mt-5">
    <div class="card shadow admin-card">

        <div class="card-header d-flex justify-content-between align-items-center">
                <h2>Listagem de Categorias</h2>

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
            <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>ID da Categoria</th>
                        <th>Nome da Categoria</th>
                        <th>Descricao da Categoria</th>
                        <th>Status</th>
                        <th>Opções</th>
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
                                    <div class="d-flex gap-2">
                                    <a href="cadastrar/categoria/<?= $dados->id ?>" class="btn btn-success">
                                        Editar
                                    </a>
                                    <a href="javascript:excluir(<?= $dados->id ?>)" class="btn btn-danger">
                                        Excluir
                                    </a>
                                  </div>
                                </td>
                            </tr>
                            <?php
                        }
                    ?>
                </tbody>
            </table>
         </div>
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

