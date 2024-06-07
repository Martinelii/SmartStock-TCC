<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../src/php/log.php'; // Inclui o arquivo de log
include '../src/db/db_connection.php';

if (isset($_POST['id'])) {
    $idSolicitacao = $_POST['id'];

    $sql = "DELETE FROM requisicao WHERE ID_Solicitacao = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idSolicitacao);

    if ($stmt->execute()) {
        registrarLog('SUCESSO - Excluir Requisição', "$idSolicitacao");
        echo "success";
    } else {
        registrarLog('ERRO - Excluir Requisição', "$idSolicitacao");
        echo "error";
    }

    $stmt->close();
    $conn->close();
}
?>
