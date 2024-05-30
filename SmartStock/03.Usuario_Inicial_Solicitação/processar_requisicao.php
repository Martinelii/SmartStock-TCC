<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../src/db/db_connection.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['matricula'])) {
    header("Location: ../00.Login/index.php");
    exit();
}

if(isset($_POST['submit'])){
    $matricula = $_POST['matricula_funcionario'];
    $cargo = $_POST['cargo'];
    $setor = $_POST['setor'];
    $item = $_POST['item'];
    $quantidade = $_POST['quantidade'];
    $status = 'ABERTA';
    $dataSolicitacao = date('Y-m-d');

    if($quantidade <= 0){
        echo "<script>
        alert('Selecione uma quantidade valida!!');
        window.location.href = 'index.php';
        </script>";
        exit();
    }

    // Obtém o ID do item com base no nome
    $sql_item = "SELECT ID_Item FROM item WHERE NomeItem = '$item'";
    $result_item = $conn->query($sql_item);
    if ($result_item->num_rows > 0) {
        $row_item = $result_item->fetch_assoc();
        $item_id = $row_item['ID_Item'];
    } else {
        echo "<script>
        alert('Item não encontrado.');
        window.location.href = 'index.php';
        </script>";
        exit();
    }

    //Faz um SELECT em item para verificar se a quantidade que está sendo pedido é menor ou igual a quantidade disponivel no momento
    $sql_quantidade_disponivel = "SELECT Quantidade FROM item WHERE ID_Item = '$item_id'";
    $result_quantidade_disponivel = $conn->query($sql_quantidade_disponivel);

    if ($result_quantidade_disponivel->num_rows > 0) {
        $row_quantidade_disponivel = $result_quantidade_disponivel->fetch_assoc();
        $quantidade_disponivel = $row_quantidade_disponivel['Quantidade'];

        // Verifica se a quantidade solicitada é menor ou igual à quantidade disponível
        if ($quantidade > $quantidade_disponivel) {
            echo "<script>
            alert('Quantidade solicitada excede a quantidade disponível.');
            window.location.href = 'index.php';
            </script>";
            exit();
        }


    // Insere a nova requisição na tabela requisicao
    $sql_insert = "INSERT INTO requisicao (QuantidadeItem, CargoFuncionario, NomeItem, SetorFuncionario, StatusSolicitacao, DataSolicitacao, FK_ITEM_ID_Item, FK_CONTA_Matricula) 
                   VALUES ('$quantidade', '$cargo', '$item', '$setor', '$status', '$dataSolicitacao', '$item_id', '$matricula')";
    
    if ($conn->query($sql_insert) === TRUE) {
        echo "<script>
        alert('Requisição inserida com sucesso.');
        window.location.href = 'index.php';
        </script>";
    } else {
        echo "<script>
        alert('Erro ao inserir requisição: ' . $conn->error');
        window.location.href = 'index.php';
        </script>";
    }

    $conn->close();
}
}


if (isset($_POST['editar'])) {
    // Recuperar os dados do formulário
    $id_solicitacao = $_POST['id_solicitacao'];
    $quantidade = $_POST['quantidade'];
    $item = $_POST['item']; // Certifique-se de recuperar o valor do item do formulário também

    //Faz um SELECT em item para verificar se a quantidade que está sendo pedido é menor ou igual a quantidade disponivel no momento
    $sql_quantidade_disponivel = "SELECT Quantidade FROM item WHERE ID_Item = '$item_id'";
    $result_quantidade_disponivel = $conn->query($sql_quantidade_disponivel);

    if ($result_quantidade_disponivel->num_rows > 0) {
        $row_quantidade_disponivel = $result_quantidade_disponivel->fetch_assoc();
        $quantidade_disponivel = $row_quantidade_disponivel['Quantidade'];

        // Verifica se a quantidade solicitada é menor ou igual à quantidade disponível
        if ($quantidade > $quantidade_disponivel) {
            echo "<script>
            alert('Quantidade solicitada excede a quantidade disponível.');
            window.location.href = 'index.php';
            </script>";
            exit();
        }
    }

    // Atualizar a quantidade e o nome do item no banco de dados
    $sql = "UPDATE requisicao SET QuantidadeItem = '$quantidade', NomeItem = '$item' WHERE ID_Solicitacao = '$id_solicitacao'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>
        alert('Dados atualizados com sucesso.');
        window.location.href = 'index.php';
        </script>";
    } else {
        echo "<script>
        alert('Erro ao Atualizar a requisição: ' . $conn->error');
        window.location.href = 'index.php';
        </script>";
    }

    // Fechar a conexão com o banco de dados
    $conn->close();
}

?>