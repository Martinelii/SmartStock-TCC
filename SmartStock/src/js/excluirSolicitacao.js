function excluirSolicitacao(id) {
    if (confirm('Tem certeza de que deseja cancelar esta solicitação?')) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "processar_exclusao.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                console.log("ReadyState: " + xhr.readyState);
                console.log("Status: " + xhr.status);
                console.log("Response Text: " + xhr.responseText);

                if (xhr.status === 200) {
                    var responseText = xhr.responseText.trim();
                    if (responseText.endsWith("success")) {
                        alert("Solicitação cancelada com sucesso.");
                        location.reload();
                    } else {
                        alert("Erro ao cancelar a solicitação.");
                    }
                } else {
                    alert("Erro na comunicação com o servidor. Status: " + xhr.status);
                }
            }
        };
        xhr.send("id=" + id);
    }
}
