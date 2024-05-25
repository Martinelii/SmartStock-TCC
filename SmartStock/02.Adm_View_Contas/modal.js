function abrirModal(matricula) {
    var row = document.querySelector(`tr[data-matricula='${matricula}']`);
    document.getElementById('matriculaModal').value = matricula;
    document.getElementById('emailModal').value = row.cells[1].innerText;
    document.getElementById('senhaModal').value = row.cells[2].innerText;
    document.getElementById('cargoModal').value = row.cells[3].innerText;
    document.getElementById('setorModal').value = row.cells[4].innerText;
    document.getElementById('funcaoModal').value = row.cells[5].innerText;
    document.getElementById('statusModal').value = row.cells[6].innerText;
    document.getElementById('modalAlterar').style.display = 'block';
}

function fecharModal() {
    document.getElementById('modalAlterar').style.display = 'none';
}
