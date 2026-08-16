<?php
if (!isset($page)) exit;
?>

<div class="container" style="padding-top: 60px; padding-bottom: 80px;">
    <div class="card shadow">

        <div class="card-header">
            <div class="float-start">
                <h2>Listagem de Produtos</h2>
            </div>

            <div class="float-end">
                <a href="cadastrar/produto" class="btn btn-success">
                    Novo Registro
                </a>

                <a href="listar/produto" class="btn btn-success">
                    Listar Registro
                </a>
            </div>
        </div>

        <div class="card-body p-4">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <td>Imagem do Produto</td>
                        <td>ID</td>
                        <td>Categoria</td>
                        <td>Nome do Produto</td>
                        <td>Descrição</td>
                        <td>Preço</td>
                        <td>Marca</td>
                        <td>Opções</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sqlListar = "select p.id, p.categoria_id, c.nome as categoria, p.nome, p.descricao, p.preco, p.marca, p.img from produto p
                        inner join categoria c on p.categoria_id = c.id order by p.id; ";
                        $consultaListar = $pdo->prepare($sqlListar);
                        $consultaListar->execute();

                        $dadosListar = $consultaListar->fetchAll(PDO::FETCH_OBJ);

                        foreach ($dadosListar as $dados) {
                            ?>
                            <tr>
                                <td>
                                    <?php if (!empty($dados->img)): ?>
                                        <img src="arquivos/<?= $dados->img ?>" alt="<?= $dados->nome ?>" class="img-thumbnail imagem-produto" width="80">
                                            <?php else: ?>
                                                Sem imagem
                                        <?php endif; ?>
                                </td>
                                <td><?= $dados->id ?></td>
                                <td><?= $dados->categoria ?></td>
                                <td><?= $dados->nome ?></td>
                                <td><?= $dados->descricao ?></td>
                                <td><?= $dados->preco ?></td>
                                <td><?= $dados->marca ?></td>

                                <td>
                                  <div class="d-flex gap-2">
                                    <a href="cadastrar/produto/<?= $dados->id ?>" class="btn btn-success">
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
                        location.href = `excluir/produto/${id}`;
                    }

                });
            }
            </script>
        </div>
    </div>
</div>

