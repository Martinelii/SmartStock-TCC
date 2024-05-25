function preencherFormulario(id, matricula, cargo, setor, item, quantidade) {
    document.getElementById('id_solicitacao').value = id;
    document.getElementById('matricula_funcionario').value = matricula;
    document.getElementById('cargo').value = cargo;
    document.getElementById('setor').value = setor;
    document.getElementById('item').value = item;
    document.getElementById('quantidade').value = quantidade;
}

function preencherFormularioAlmox(idSolicitacao, matricula, idItem, item, quantidade){
    document.getElementById('id_solicitacao').value = idSolicitacao;
    document.getElementById('matricula_funcionario').value = matricula;
    document.getElementById('id_item').value = idItem;
    document.getElementById('item').value = item;
    document.getElementById('quantidade').value = quantidade;
}

function editarFormulario(id, matricula, cargo, setor, item, quantidade) {
    document.getElementById('id_solicitacao').value = id;
    document.getElementById('matricula_funcionario').value = matricula;
    document.getElementById('cargo').value = cargo;
    document.getElementById('setor').value = setor;
    document.getElementById('item').value = item;
    document.getElementById('quantidade').value = quantidade;

    document.getElementById("btnConfirmar").style ="display: none;";
    document.getElementById("btnEditar").style ="display: block;";
}

function preencherFormularioAprovador(id_solicitacao, matricula_funcionario, cargo, setor, item, quantidade) {
    document.getElementById('id_solicitacao_aprovar').value = id_solicitacao;
    document.getElementById('id_solicitacao_recusar').value = id_solicitacao;
    document.getElementById('matricula_funcionario').value = matricula_funcionario;
    document.getElementById('cargo').value = cargo;
    document.getElementById('setor').value = setor;
    document.getElementById('item').value = item;
    document.getElementById('quantidade').value = quantidade;
}
