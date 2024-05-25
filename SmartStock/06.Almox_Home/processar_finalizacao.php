<?php
session_start();
include '../src/db/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_solicitacao = $_POST['id_solicitacao'];
    $acao = 'FINALIZADA'; // Definimos a ação como FINALIZADA
    $item = $_POST['item']; // Nome do item solicitado
    $quantidade_solicitada = (int) $_POST['quantidade']; // Quantidade solicitada

    // Verifica a quantidade disponível no estoque
    $sql_verifica_estoque = "SELECT Quantidade FROM item WHERE NomeItem = ?";
    $stmt_verifica_estoque = $conn->prepare($sql_verifica_estoque);
    $stmt_verifica_estoque->bind_param('s', $item);
    $stmt_verifica_estoque->execute();
    $stmt_verifica_estoque->bind_result($quantidade_estoque);
    $stmt_verifica_estoque->fetch();
    $stmt_verifica_estoque->close();

    if ($quantidade_estoque >= $quantidade_solicitada) {
        // Atualiza a quantidade no estoque
        $nova_quantidade_estoque = $quantidade_estoque - $quantidade_solicitada;
        $sql_atualiza_estoque = "UPDATE item SET Quantidade = ? WHERE NomeItem = ?";
        $stmt_atualiza_estoque = $conn->prepare($sql_atualiza_estoque);
        $stmt_atualiza_estoque->bind_param('is', $nova_quantidade_estoque, $item);
        $stmt_atualiza_estoque->execute();
        $stmt_atualiza_estoque->close();

        // Atualiza o status da solicitação para "FINALIZADA"
        $sql_atualiza_solicitacao = "UPDATE requisicao SET StatusSolicitacao = ? WHERE ID_Solicitacao = ?";
        $stmt_atualiza_solicitacao = $conn->prepare($sql_atualiza_solicitacao);
        $stmt_atualiza_solicitacao->bind_param('si', $acao, $id_solicitacao);
        $stmt_atualiza_solicitacao->execute();
        $stmt_atualiza_solicitacao->close();

        echo "Solicitação {$acao} com sucesso!";
    } else {
        // Atualiza o status da solicitação para "INSUFICIENTE"
        $acao_insuficiente = 'INSUFICIENTE';
        $sql_atualiza_solicitacao = "UPDATE requisicao SET StatusSolicitacao = ? WHERE ID_Solicitacao = ?";
        $stmt_atualiza_solicitacao = $conn->prepare($sql_atualiza_solicitacao);
        $stmt_atualiza_solicitacao->bind_param('si', $acao_insuficiente, $id_solicitacao);
        $stmt_atualiza_solicitacao->execute();
        $stmt_atualiza_solicitacao->close();

        echo "<script>
                alert('Quantidade insuficiente no estoque. Solicitação marcada como INSUFICIENTE.');
                window.location.href = 'index.php';
              </script>";
        exit();
    }

    $conn->close();

    // Redireciona de volta para a página inicial ou uma página de sucesso
    header("Location: index.php");
    exit();
} else {
    header("Location: index.php");
    exit();
}
?>
