<?php
if (!isset($page)) exit;
?>

<div class="container pt-5 pb-5 mt-5">
    <div class="card shadow admin-card">

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
                        <th>Imagem do Produto</th>
                        <th>ID do Estoque</th>
                        <th>ID do Produto</th>
                        <th>Nome do Produto</th>
                        <th>Quantidade</th>
                        <th>Opções</th>
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
                                <td>
                                    <?php if (!empty($dados->img)) { ?>
                                        <img src="arquivos/<?= $dados->img ?>" alt="<?= $dados->produto ?>" class="imagem-produto">
                                    <?php } else { ?>
                                        <span>Sem imagem</span>
                                    <?php } ?>
                                </td>
                                <td><?= $dados->id ?></td>
                                <td><?= $dados->produto_id ?></td>
                                <td><?= $dados->produto ?></td>
                                <td><?= $dados->quantidade ?></td>

                                <td>
                                    <div class="d-flex gap-2">
                                    <a href="cadastrar/estoque/<?= $dados->id ?>" class="btn btn-success">
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

