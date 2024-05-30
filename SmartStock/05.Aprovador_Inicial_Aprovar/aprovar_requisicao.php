<?php
session_start();
include '../src/db/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_solicitacao = $_POST['id_solicitacao'];

    // Verificar se a quantidade solicitada está disponível no estoque
    $sql_check_stock = "SELECT QuantidadeItem, FK_ITEM_ID_Item FROM requisicao WHERE ID_Solicitacao = ?";
    $stmt_check_stock = $conn->prepare($sql_check_stock);
    $stmt_check_stock->bind_param('i', $id_solicitacao);
    $stmt_check_stock->execute();
    $result_check_stock = $stmt_check_stock->get_result();

    if ($result_check_stock->num_rows > 0) {
        $row = $result_check_stock->fetch_assoc();
        $quantidade_solicitada = $row['QuantidadeItem'];
        $id_item = $row['FK_ITEM_ID_Item'];

        // Verificar a quantidade disponível em estoque para o item
        $sql_get_stock = "SELECT Quantidade FROM item WHERE ID_Item = ?";
        $stmt_get_stock = $conn->prepare($sql_get_stock);
        $stmt_get_stock->bind_param('i', $id_item);
        $stmt_get_stock->execute();
        $result_get_stock = $stmt_get_stock->get_result();

        if ($result_get_stock->num_rows > 0) {
            $row_stock = $result_get_stock->fetch_assoc();
            $quantidade_estoque = $row_stock['Quantidade'];

            if ($quantidade_solicitada > $quantidade_estoque) {
                // Quantidade solicitada excede o estoque disponível, recusar automaticamente
                echo "Quantidade solicitada excede o estoque disponível. Solicitação recusada automaticamente.";
                $acao = 'RECUSADA';
            } else {
                $acao = 'APROVADA';
            }

            $stmt_get_stock->close();
        } else {
            echo "<script>
            alert('Item não encontrado no estoque.');
            window.location.href = 'index.php';
            </script>";
            exit();
        }
    } else {
        echo "<script>
        alert('Solicitação não encontrada.');
        window.location.href = 'index.php';
        </script>";
        
        exit();
    }

    $stmt_check_stock->close();

    // Atualiza o status da solicitação
    $sql_update_status = "UPDATE requisicao SET StatusSolicitacao = ? WHERE ID_Solicitacao = ?";
    $stmt_update_status = $conn->prepare($sql_update_status);
    $stmt_update_status->bind_param('si', $acao, $id_solicitacao);

    if ($stmt_update_status->execute()) {
        echo "<script>
        alert('Solicitação Aprovada com sucesso!');
        window.location.href = 'index.php';
        </script>";
        
    } else {
        echo "<script>
        alert('Erro ao Aprovar a solicitação: . $conn->error');
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
