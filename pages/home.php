<?php
if (!isset($page)) exit;
?>

<div class="container">
    <div class="dashboard-titulo mb-4">
        <h2>Painel Administrativo Kaeru</h2>
        <p>Visão geral dos produtos e estoque do sistema.</p>
    </div>
    <div class="row g-4">
                <div class="col-12 col-md-4">
            <div class="card shadow dashboard-card">
                <div class="card-body text-center">
                    <h5>Produtos com Estoque</h5>
                    <h2 id="total-produtos">0</h2>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card shadow dashboard-card">
                <div class="card-body text-center">
                    <h5>Total de Categorias</h5>
                    <h2 id="total-categorias">0</h2>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card shadow dashboard-card">
                <div class="card-body text-center">
                    <h5>Valor em Estoque</h5>
                    <h2 id="valor-estoque">R$ 0,00</h2>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="card shadow dashboard-card dashboard-lista">
                <div class="card-header">
                    <h4>Ranking de Estoque</h4>
                </div>
                <div class="card-body">
                    <div id="ranking-estoque">

                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="card shadow dashboard-card dashboard-lista">
                <div class="card-header">
                    <h4>Produtos com Estoque Baixo</h4>
                </div>

                <div class="card-body">
                    <div id="estoque-baixo"></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12">
            <div class="card shadow dashboard-card dashboard-destaque">
                <div class="card-body text-center">
                    <h5>Maior Estoque</h5>
                    <h2 id="maior-estoque">-</h2>
                </div>
            </div>
        </div>
    </div>
</div>