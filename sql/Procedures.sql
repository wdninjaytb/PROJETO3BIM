CREATE PROCEDURE buscar_produtos_dashboard(
    IN id_categoria INT,
    IN termo VARCHAR(150),
    IN limite INT,
    IN deslocamento INT
)
BEGIN
    SELECT
        p.id,
        p.categoria_id,
        p.nome,
        p.descricao,
        p.preco,
        p.marca,
        p.img,
        e.quantidade
    FROM produto p
    LEFT JOIN estoque e
        ON e.produto_id = p.id
    WHERE
        (id_categoria IS NULL OR p.categoria_id = id_categoria)
        AND
        (termo IS NULL OR p.nome LIKE CONCAT('%', termo, '%'))
    ORDER BY p.nome
    LIMIT limite
    OFFSET deslocamento;
END;

CREATE PROCEDURE buscar_produtos_categoria(
    IN id_categoria INT
)
BEGIN
    SELECT
        p.id,
        p.nome,
        p.preco,
        p.marca
    FROM produto p
    WHERE p.categoria_id = id_categoria
    ORDER BY p.nome;
END;