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
function iniciar() {
    return __awaiter(this, void 0, void 0, function* () {
        const produtos = yield buscarProdutos();
        console.log(produtos);
    });
}
iniciar();
