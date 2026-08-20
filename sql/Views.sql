CREATE OR REPLACE VIEW vw_estoque_detalhado AS
SELECT
    p.id AS produto_id,
    p.nome AS produto,
    c.nome AS categoria,
    p.preco,
    e.quantidade,
    calcular_valor_estoque(p.preco, e.quantidade) AS valor_estoque
FROM produto p
INNER JOIN categoria c
    ON p.categoria_id = c.id
INNER JOIN estoque e
    ON p.id = e.produto_id;

CREATE OR REPLACE VIEW vw_valor_estoque_categoria AS
SELECT
    c.id AS categoria_id,
    c.nome AS categoria,
    SUM(
        calcular_valor_estoque(p.preco, e.quantidade)
    ) AS valor_total_estoque
FROM categoria c
INNER JOIN produto p
    ON p.categoria_id = c.id
INNER JOIN estoque e
    ON e.produto_id = p.id
GROUP BY c.id, c.nome;