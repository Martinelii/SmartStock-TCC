function abrirModalAdicionar(idItem) {
    // Fazer uma requisição AJAX para obter os dados do item
    fetch(`atualizarItem.php?id=${idItem}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('modalIdItem').value = data.ID_Item;
            document.getElementById('modalNomeItem').value = data.NomeItem;
            document.getElementById('modalQuantidade').value = data.Quantidade;
            document.getElementById('modalAdicionar').style.display = 'block';
        });
}

function fecharModalAdicionar() {
    document.getElementById('modalAdicionar').style.display = 'none';
}

// Fechar a modal se o usuário clicar fora dela
window.onclick = function(event) {
    if (event.target == document.getElementById('modalAdicionar')) {
        fecharModalAdicionar();
    }
}
