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
;
function buscarCategorias() {
    return __awaiter(this, void 0, void 0, function* () {
        try {
            const response = yield fetch("http://localhost:8080/PROJETO3BIM/api/categorias.php");
            if (!response.ok) {
                throw new Error("Erro ao consultar categorias");
            }
            const categorias = yield response.json();
            return categorias;
        }
        catch (erro) {
            console.error("Erro ao buscar categorias: ", erro);
            return [];
        }
    });
}
function iniciarCategorias() {
    return __awaiter(this, void 0, void 0, function* () {
        const categorias = yield buscarCategorias();
        const totalCategorias = categorias.length;
        const elementoTotalCategorias = document.getElementById("total-categorias");
        if (elementoTotalCategorias) {
            elementoTotalCategorias.textContent = totalCategorias.toString();
        }
    });
}
iniciarCategorias();
