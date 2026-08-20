create function calcular_valor_estoque(
	preco DECIMAL(10,2),
	quantidade INT

)
returns decimal(10,2)
deterministic
begin
	return preco * quantidade;
end



