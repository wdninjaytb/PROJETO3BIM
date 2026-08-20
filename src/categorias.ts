interface Categoria {
    id: number;
    nome: string;
    descricao: string;
    ativo: number;
};

async function buscarCategorias(): Promise<Categoria[]> {
    try {
        const response = await fetch("http://localhost:8080/PROJETO3BIM/api/categorias.php");

        if (!response.ok) {
            throw new Error("Erro ao consultar categorias");
        }

        const categorias: Categoria[] = await response.json();

        return categorias;
    } catch (erro) {
        console.error("Erro ao buscar categorias: ", erro);

        return [];
    }
}

async function iniciarCategorias(): Promise<void> {
    const categorias = await buscarCategorias();

    const totalCategorias = categorias.length;

    const elementoTotalCategorias = document.getElementById("total-categorias");

    if (elementoTotalCategorias) {
        elementoTotalCategorias.textContent = totalCategorias.toString();
    }
    
}

iniciarCategorias();