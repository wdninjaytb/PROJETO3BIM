interface Produto {
    id: number;
    categoria_id: number;
    nome: string;
    descricao: string;
    preco: string;
    marca: string;
    img: string;
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

async function iniciar(): Promise<void> {
    const produtos = await buscarProdutos();

    console.log(produtos);
}

iniciar();