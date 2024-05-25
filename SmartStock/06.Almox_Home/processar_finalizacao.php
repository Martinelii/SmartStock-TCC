<?php
session_start();
include '../src/db/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_solicitacao = $_POST['id_solicitacao'];
    $acao = $_POST['acao'];

    // Atualiza o status da solicitação para "FINALIZADA"
    $sql = "UPDATE requisicao SET StatusSolicitacao = ? WHERE ID_Solicitacao = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $acao, $id_solicitacao);

    if ($stmt->execute()) {
        echo "Solicitação {$acao} com sucesso!";
    } else {
        echo "Erro ao atualizar a solicitação: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
    
    // Redireciona de volta para a página inicial ou uma página de sucesso
    header("Location: index.php");
    exit();
} else {
    header("Location: index.php");
    exit();
}
?>
