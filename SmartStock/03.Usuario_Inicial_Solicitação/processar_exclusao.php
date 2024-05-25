<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../src/db/db_connection.php';

if (isset($_POST['id'])) {
    $idSolicitacao = $_POST['id'];

    $sql = "DELETE FROM requisicao WHERE ID_Solicitacao = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idSolicitacao);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }

    $stmt->close();
    $conn->close();
}
?>
