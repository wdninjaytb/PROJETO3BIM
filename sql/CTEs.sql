WITH estoque_detalhado AS (
    SELECT
        p.id AS produto_id,
        p.nome AS produto,
        c.nome AS categoria,
        p.preco,
        e.quantidade,
        p.preco * e.quantidade AS valor_estoque
    FROM produto p
    INNER JOIN categoria c
        ON p.categoria_id = c.id
    INNER JOIN estoque e
        ON p.id = e.produto_id
)
SELECT *
FROM estoque_detalhado;