<?php
if (!isset($page)) exit;
?>

<div class="container pt-5 pb-5 mt-5">
    <div class="card shadow">

        <div class="card-header">
            <div class="float-start">
                <h2>Listagem de Estoques</h2>
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
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <td>ID do Estoque</td>
                        <td>ID do Produto</td>
                        <td>Imagem do Produto</td>
                        <td>Nome do Produto</td>
                        <td>Quantidade</td>
                        <td>Opções</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sqlListar = "select e.id, e.produto_id, p.nome as produto, p.img, e.quantidade from estoque e
                            inner join produto p on e.produto_id = p.id order by p.nome; ";
                        $consultaListar = $pdo->prepare($sqlListar);
                        $consultaListar->execute();

                        $dadosListar = $consultaListar->fetchAll(PDO::FETCH_OBJ);

                        foreach ($dadosListar as $dados) {
                            ?>
                            <tr>
                                <td><?= $dados->img ?></td>
                                <td><?= $dados->id ?></td>
                                <td><?= $dados->produto_id ?></td>
                                <td><?= $dados->produto ?></td>
                                <td><?= $dados->quantidade ?></td>

                                <td>
                                    <a href="cadastrar/estoque/<?= $dados->id ?>" class="btn btn-success">
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
                        location.href = `excluir/estoque/${id}`;
                    }

                });
            }
            </script>

        </div>
    </div>
</div>

