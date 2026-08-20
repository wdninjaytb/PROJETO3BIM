<?php
if (!isset($page)) exit;
?>

<div class="container" style="padding-top: 60px; padding-bottom: 80px;">
    <div class="card shadow admin-card">

        <div class="card-header d-flex justify-content-between align-items-center">
                <h2>Listagem de Produtos</h2>

            <div class="d-flex gap-2">
                <a href="cadastrar/produto" class="btn btn-success">
                    Novo Registro
                </a>

                <a href="listar/produto" class="btn btn-success">
                    Listar Registro
                </a>
            </div>
        </div>

        <div class="card-body p-4">
            <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>Imagem do Produto</th>
                        <th>ID</th>
                        <th>Categoria</th>
                        <th>Nome do Produto</th>
                        <th>Descrição</th>
                        <th>Preço</th>
                        <th>Marca</th>
                        <th>Opções</th>
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
                                <td style="min-width: 250px;"><?= $dados->descricao ?></td>
                                <td>R$ <?= number_format($dados->preco, 2, ',', '.') ?></td>
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
             </div>
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

