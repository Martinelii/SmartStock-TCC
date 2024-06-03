<?php
session_start();
include '../src/db/db_connection.php';
include_once '../src/php/log.php'; // Inclui o arquivo de log

if (!isset($_SESSION['matricula'])) {
    header("Location: ../00.Login/index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    // Processa o formulário de atualização do item
    $idItem = $_POST['idItem'];
    $quantidade = $_POST['quantidade'];

    //Impede Negativar Estoque
    if($quantidade < 0){
        echo "<script>
        alert('Não é Possivel Negativar Estoque');
        window.location.href = 'index.php';
        </script>";
        exit();
    }

    // Atualiza a quantidade do item no banco de dados
    $sql = "UPDATE item SET Quantidade = ? WHERE ID_Item = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $quantidade, $idItem);

    if ($stmt->execute()) {
        registrarLog('Quantidade Item Atualizada',"ID Item: $idItem, Quantidade: $quantidade");
        echo "<script>
        alert('Item atualizado com sucesso.');
        window.location.href = 'index.php';
        </script>";
    } else {
        registrarLog('Atualizar Quantidade Item'," FALHA - ID Item: $idItem");
        echo "<script>
        alert('Erro ao atualizar o item: ' . $stmt->error);
        window.location.href = 'index.php';
        </script>";
    }

    $stmt->close();
    $conn->close();
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    // Obtém os dados do item via AJAX
    $id = $_GET['id'];

    $sql = "SELECT ID_Item, NomeItem, Quantidade FROM item WHERE ID_Item = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $item = $result->fetch_assoc();

    echo json_encode($item);

    $stmt->close();
    $conn->close();
    exit();
}
?>
