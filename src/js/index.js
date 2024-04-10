// obtendo os botoes de ação da página
const btnLogin = document.querySelector('.btn-login');
const btnCadastro = document.querySelector('.btn-cadastro');
const btnCadastroItem = document.querySelector('.btn-cadastro-item');
const btnEstoque = document.querySelector('.btn-estoque');

// funções de ação dos botões temporarios
btnLogin.addEventListener('click', () => {
    irPara('login');
})

btnCadastro.addEventListener('click', () => {
    irPara('cadastro');
})

btnCadastroItem.addEventListener('click', () => {
    irPara('cadastro-item');
})

btnEstoque.addEventListener('click', () => {
    irPara('estoque');
})


// funções globais - navegabilidade
function irPara(pagina){
    window.location.href = "/" + pagina;
}