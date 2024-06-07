<?php
session_start();
include '../src/db/db_connection.php';
include '../src/php/log.php'; // Inclui o arquivo de log

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_solicitacao = $_POST['id_solicitacao'];
    $acao = 'RECUSADA';

    // Atualiza o status da solicitação
    $sql_update_status = "UPDATE requisicao SET StatusSolicitacao = ? WHERE ID_Solicitacao = ?";
    $stmt_update_status = $conn->prepare($sql_update_status);
    $stmt_update_status->bind_param('si', $acao, $id_solicitacao);

    if ($stmt_update_status->execute()) {
        registrarLog('SUCESSO - Recusar Solicitação', "Solicitação $id_solicitacao Recusada!!");
        echo "<script>
        alert('Solicitação Recusada com sucesso!');
        window.location.href = 'index.php';
        </script>";
    } else {
        registrarLog('ERRO - Recusar Solicitação', "Solicitação $id_solicitacao, erro na comunicação com servidor!!");
        echo "<script>
        alert('Erro ao Recusar a solicitação: . $conn->error');
        window.location.href = 'index.php';
        </script>";
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
