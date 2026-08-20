CREATE TRIGGER produto_preco_positivo
BEFORE UPDATE ON produto
FOR EACH ROW
BEGIN
    IF NEW.preco < 0 THEN
        SET NEW.preco = 0;
    END IF;
END;