const imagens = ["aprov-req-gert.png", "cad-conta.png", "cad-item.png",
                "fin-req-almo.png", "req-item-func.png", "visu-estoq.png",
                "visu-solic.png"];

const legendas = ["Menu de Aprovação de Requisições • Gerente", 
                "Menu de Cadastro de Contas • Administrador",
                "Menu de Cadastro de Itens • Almoxarife", 
                "Menu de Finalização de Requisições • Almoxarife",
                "Menu de Requisição de Itens • Funcionário", 
                "Menu de Visualização de Estoque • Almoxarife",
                "Menu de Visualização de Solicitações • Almoxarife"];

let indiceAtual = 0;

function carregarImagemInicial() {
    indiceAtual = Math.floor(Math.random() * imagens.length);
    atualizarImagem();
}

function atualizarImagem() {
    document.getElementById("imagem").src = "./99.Apresentacao/img/secao-imgs/" + imagens[indiceAtual];
    document.getElementById("texto-legenda").innerText = legendas[indiceAtual];
}

function proximaImagem() {
    indiceAtual = (indiceAtual + 1) % imagens.length;
    atualizarImagem();
}

function imagemAnterior() {
    indiceAtual = (indiceAtual - 1 + imagens.length) % imagens.length;
    atualizarImagem();
}

document.addEventListener("DOMContentLoaded", function() {
    document.querySelector(".sucessor").addEventListener("click", proximaImagem);
    document.querySelector(".anterior").addEventListener("click", imagemAnterior);
    carregarImagemInicial();
});

window.onload = carregarImagemInicial;



document.addEventListener("DOMContentLoaded", function() {
    const modal = document.getElementById("modal");
    const imagemModal = document.getElementById("imagemModal");
    const legendaModal = document.getElementById("legendaModal");
    const fechar = document.getElementById("fechar");

    document.getElementById("imagem").addEventListener("click", function() {
        modal.style.display = "block";
        imagemModal.src = this.src;
        legendaModal.innerText = document.getElementById("texto-legenda").innerText;
    });

    fechar.onclick = function() { 
        modal.style.display = "none";
    }

    modal.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }
});
