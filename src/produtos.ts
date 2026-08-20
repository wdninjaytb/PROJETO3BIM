interface Produto {
    id: number;
    categoria_id: number;
    nome: string;
    descricao: string;
    preco: string;
    marca: string | null;
    img: string | null;
    quantidade: number;
}

interface DadosEstoque {
    nome: string;
    quantidade: number;
}

async function buscarProdutos(): Promise<Produto[]> {
    try {
        const response = await fetch("/PROJETO3BIM/api/produtos.php");

        if(!response.ok) {
            throw new Error("Erro ao consultar a API");
        }

        const produtos: Produto[] = await response.json();

        return produtos;
    } catch (erro) {
        console.error("Erro ao buscar produtos:", erro);

        return [];
    }
}

function mostrarTotalProdutos(produtos: Produto[]): void {
    const produtosComEstoque = produtos.filter(
        produto => produto.quantidade > 0
    )

    const totalProdutos = produtosComEstoque.length
    
    const elementoTotalProdutos = document.getElementById("total-produtos");

    if(elementoTotalProdutos) {
        elementoTotalProdutos.textContent = totalProdutos.toString();
    }
}

function calcularValorEstoque(produtos: Produto[]): number {
     return produtos.reduce((total, produto) => {
        const preco = Number(produto.preco);

            if (isNaN(preco) || produto.quantidade < 0) {
                return total;
            }

                return total + preco * produto.quantidade;
    }, 0);
}

function mostrarValorEstoque(valorEstoque: number): void {
    const elementoValorEstoque = document.getElementById("valor-estoque");
    if (elementoValorEstoque) {
    elementoValorEstoque.textContent = valorEstoque.toLocaleString(
        "pt-BR",
        {
            style: "currency",
            currency: "BRL"
        }
    );
}
}

function filtrarEstoqueBaixo(produtos: Produto[]): Produto[] {
    return produtos.filter(
        produto => produto.quantidade > 0 && produto.quantidade <= 5
    );
}

function mostrarEstoqueBaixo(produtos: Produto[]): void {
    const divEstoqueBaixo = document.getElementById("estoque-baixo");
    if (!divEstoqueBaixo) {
        return;
    }
    
    if(produtos.length === 0) {
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
    })
}

function criarRankingEstoque(produtos: Produto[]): DadosEstoque[] {
    const dadosEstoque: DadosEstoque[] = produtos.map(produto => {
        return {
            nome: produto.nome,
            quantidade: produto.quantidade
    };
});

    const rankingEstoque = [...dadosEstoque];
    rankingEstoque.sort((a, b) => b.quantidade - a.quantidade);
    return rankingEstoque.slice(0,10);
}

function mostrarRankingEstoque(ranking: DadosEstoque[]): void {
    const divRankingEstoque = document.getElementById("ranking-estoque");

    if(!divRankingEstoque) {
        return
    }

    ranking.forEach((produto, indice) => {
        const item = document.createElement("p");
        item.classList.add("item-ranking");
        item.textContent = `${indice + 1}º ${produto.nome} - ${produto.quantidade} unidades`
        divRankingEstoque.appendChild(item);

    }); 
}

function mostrarMaiorEstoque(ranking: DadosEstoque[]): void {
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

async function iniciar(): Promise<void> {
    const produtos = await buscarProdutos();

    mostrarTotalProdutos(produtos);

    const valorEstoque = calcularValorEstoque(produtos);
    mostrarValorEstoque(valorEstoque);

    const estoqueBaixo = filtrarEstoqueBaixo(produtos);
    mostrarEstoqueBaixo(estoqueBaixo);

    const rankingEstoque = criarRankingEstoque(produtos);
    mostrarRankingEstoque(rankingEstoque);
    mostrarMaiorEstoque(rankingEstoque);

}

iniciar();