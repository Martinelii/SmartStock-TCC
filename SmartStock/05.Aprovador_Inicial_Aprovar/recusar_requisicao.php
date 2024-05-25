<?php
session_start();
include '../src/db/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_solicitacao = $_POST['id_solicitacao'];
    $acao = 'RECUSADA';

    // Atualiza o status da solicitação
    $sql_update_status = "UPDATE requisicao SET StatusSolicitacao = ? WHERE ID_Solicitacao = ?";
    $stmt_update_status = $conn->prepare($sql_update_status);
    $stmt_update_status->bind_param('si', $acao, $id_solicitacao);

    if ($stmt_update_status->execute()) {
        echo "Solicitação {$acao} com sucesso!";
    } else {
        echo "Erro ao atualizar a solicitação: " . $conn->error;
    }

    $stmt_update_status->close();
    $conn->close();
    
    // Redireciona de volta para a página inicial ou uma página de sucesso
    header("Location: index.php");
    exit();
} else {
    header("Location: index.php");
    exit();
}
?>
