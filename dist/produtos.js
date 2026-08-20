"use strict";
var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
function buscarProdutos() {
    return __awaiter(this, void 0, void 0, function* () {
        try {
            const response = yield fetch("/PROJETO3BIM/api/produtos.php");
            if (!response.ok) {
                throw new Error("Erro ao consultar a API");
            }
            const produtos = yield response.json();
            return produtos;
        }
        catch (erro) {
            console.error("Erro ao buscar produtos:", erro);
            return [];
        }
    });
}
function mostrarTotalProdutos(produtos) {
    const produtosComEstoque = produtos.filter(produto => produto.quantidade > 0);
    const totalProdutos = produtosComEstoque.length;
    const elementoTotalProdutos = document.getElementById("total-produtos");
    if (elementoTotalProdutos) {
        elementoTotalProdutos.textContent = totalProdutos.toString();
    }
}
function calcularValorEstoque(produtos) {
    return produtos.reduce((total, produto) => {
        const preco = Number(produto.preco);
        if (isNaN(preco) || produto.quantidade < 0) {
            return total;
        }
        return total + preco * produto.quantidade;
    }, 0);
}
function mostrarValorEstoque(valorEstoque) {
    const elementoValorEstoque = document.getElementById("valor-estoque");
    if (elementoValorEstoque) {
        elementoValorEstoque.textContent = valorEstoque.toLocaleString("pt-BR", {
            style: "currency",
            currency: "BRL"
        });
    }
}
function filtrarEstoqueBaixo(produtos) {
    return produtos.filter(produto => produto.quantidade > 0 && produto.quantidade <= 5);
}
function mostrarEstoqueBaixo(produtos) {
    const divEstoqueBaixo = document.getElementById("estoque-baixo");
    if (!divEstoqueBaixo) {
        return;
    }
    if (produtos.length === 0) {
        const mensagem = document.createElement("p");
        mensagem.classList.add("mensagem-estoque");
        mensagem.textContent = "Nenhum produto com estoque baixo";
        divEstoqueBaixo.appendChild(mensagem);
        return;
    }
    produtos.forEach(produto => {
        const item = document.createElement("p");
        item.classList.add("item-estoque-baixo");
        const unidade = produto.quantidade === 1 ? "unidade" : "unidades";
        item.textContent = `${produto.nome} - ${produto.quantidade} ${unidade}`;
        divEstoqueBaixo.appendChild(item);
    });
}
function criarRankingEstoque(produtos) {
    const dadosEstoque = produtos.map(produto => {
        return {
            nome: produto.nome,
            quantidade: produto.quantidade
        };
    });
    const rankingEstoque = [...dadosEstoque];
    rankingEstoque.sort((a, b) => b.quantidade - a.quantidade);
    return rankingEstoque.slice(0, 10);
}
function mostrarRankingEstoque(ranking) {
    const divRankingEstoque = document.getElementById("ranking-estoque");
    if (!divRankingEstoque) {
        return;
    }
    ranking.forEach((produto, indice) => {
        const item = document.createElement("p");
        item.classList.add("item-ranking");
        item.textContent = `${indice + 1}º ${produto.nome} - ${produto.quantidade} unidades`;
        divRankingEstoque.appendChild(item);
    });
}
function mostrarMaiorEstoque(ranking) {
    const elemento = document.getElementById("maior-estoque");
    if (!elemento) {
        return;
    }
    if (ranking.length === 0) {
        elemento.textContent = "Nenhum dado";
        return;
    }
    const maior = ranking[0];
    elemento.textContent = `${maior.nome} - ${maior.quantidade} unidades`;
}
function iniciar() {
    return __awaiter(this, void 0, void 0, function* () {
        const produtos = yield buscarProdutos();
        mostrarTotalProdutos(produtos);
        const valorEstoque = calcularValorEstoque(produtos);
        mostrarValorEstoque(valorEstoque);
        const estoqueBaixo = filtrarEstoqueBaixo(produtos);
        mostrarEstoqueBaixo(estoqueBaixo);
        const rankingEstoque = criarRankingEstoque(produtos);
        mostrarRankingEstoque(rankingEstoque);
        mostrarMaiorEstoque(rankingEstoque);
    });
}
iniciar();
