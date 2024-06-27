<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../src/db/db_connection.php';
include '../src/php/log.php'; // Inclui o arquivo de log

date_default_timezone_set('America/Sao_Paulo');

// Verifica se o usuário está logado
if (!isset($_SESSION['matricula'])) {
    header("Location: ../00.Login/index.php");
    exit();
}

if (isset($_POST['submit'])) {
    $matricula = $_POST['matricula_funcionario'];
    $cargo = $_POST['cargo'];
    $setor = $_POST['setor'];
    $item = $_POST['item'];
    $quantidade = $_POST['quantidade'];
    $status = 'ABERTA';
    $dataSolicitacao = date('Y-m-d H:i:s'); // Obtém a data e hora atuais

    if ($quantidade <= 0) {
        registrarLog('ERRO - Efetuar Requisição', "Quantidade $quantidade Inválida!!");
        echo "<script>
        alert('Selecione uma quantidade válida!!');
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
        registrarLog('ERRO - Efetuar Requisição', "Item $item não encontrado!!");
        echo "<script>
        alert('Item não encontrado.');
        window.location.href = 'index.php';
        </script>";
        exit();
    }

    // Calcular média diária do último mês
    $sql_media_diaria = "
    SELECT AVG(daily_avg) AS media_diaria
    FROM (
        SELECT DATE(DataSolicitacao) as date, AVG(QuantidadeItem) as daily_avg
        FROM requisicao
        WHERE FK_ITEM_ID_Item = '$item_id' 
        AND DataSolicitacao >= DATE_SUB(NOW(), INTERVAL 1 MONTH)
        GROUP BY DATE(DataSolicitacao)
    ) as daily_averages;
    ";
    $result_media_diaria = $conn->query($sql_media_diaria);
    $media_diaria = ($result_media_diaria->num_rows > 0) ? $result_media_diaria->fetch_assoc()['media_diaria'] : 0;

    // Calcular média mensal dos últimos 3 meses
    $sql_media_mensal = "
    SELECT AVG(monthly_avg) AS media_mensal
    FROM (
        SELECT DATE_FORMAT(DataSolicitacao, '%Y-%m') as month, AVG(QuantidadeItem) as monthly_avg
        FROM requisicao
        WHERE FK_ITEM_ID_Item = '$item_id' 
        AND DataSolicitacao >= DATE_SUB(NOW(), INTERVAL 3 MONTH)
        GROUP BY DATE_FORMAT(DataSolicitacao, '%Y-%m')
    ) as monthly_averages;
    ";
    $result_media_mensal = $conn->query($sql_media_mensal);
    $media_mensal = ($result_media_mensal->num_rows > 0) ? $result_media_mensal->fetch_assoc()['media_mensal'] : 0;

    // Verifica se a quantidade solicitada excede a média diária ou mensal
    if ($quantidade > $media_diaria || $quantidade > $media_mensal) {
    registrarLog('ALERTA - Efetuar Requisição', "Quantidade $quantidade excede a média diária ($media_diaria) ou mensal ($media_mensal) de uso do item $item");
    }


    // Verifica a quantidade disponível do item
    $sql_quantidade_disponivel = "SELECT Quantidade FROM item WHERE ID_Item = '$item_id'";
    $result_quantidade_disponivel = $conn->query($sql_quantidade_disponivel);

    if ($result_quantidade_disponivel->num_rows > 0) {
        $row_quantidade_disponivel = $result_quantidade_disponivel->fetch_assoc();
        $quantidade_disponivel = $row_quantidade_disponivel['Quantidade'];

        // Verifica se a quantidade solicitada é menor ou igual à quantidade disponível
        if ($quantidade > $quantidade_disponivel) {
            registrarLog('ERRO - Efetuar Requisição', "Quantidade $quantidade excedente ao Estoque do item $item_id!!");
            echo "<script>
            alert('Quantidade solicitada excede a quantidade " . $quantidade_disponivel . " disponível.');
            window.location.href = 'index.php';
            </script>";
            exit();
        }

        // Insere a nova requisição na tabela requisicao
        $sql_insert = "INSERT INTO requisicao (QuantidadeItem, CargoFuncionario, NomeItem, SetorFuncionario, StatusSolicitacao, DataSolicitacao, FK_ITEM_ID_Item, FK_CONTA_Matricula) 
                       VALUES ('$quantidade', '$cargo', '$item', '$setor', '$status', '$dataSolicitacao', '$item_id', '$matricula')";

        if ($conn->query($sql_insert) === TRUE) {
            // Obtém o ID da requisição recém-inserida
            $sqlReq = "SELECT ID_Solicitacao FROM requisicao
                       WHERE FK_CONTA_Matricula = '$matricula' AND NomeItem = '$item' AND QuantidadeItem = '$quantidade' AND DataSolicitacao = '$dataSolicitacao' LIMIT 1";
            $resultReq = $conn->query($sqlReq);

            if ($resultReq->num_rows > 0) {
                $rowReq = $resultReq->fetch_assoc();
                $idRequisicao = $rowReq['ID_Solicitacao'];

                registrarLog('SUCESSO - Efetuar Requisição', "Requisição $idRequisicao, Item $item");
                echo "<script>
                alert('Requisição inserida com sucesso.');
                window.location.href = 'index.php';
                </script>";
            } else {
                registrarLog('ERRO - Efetuar Requisição', "Não foi possível obter o ID da requisição.");
                echo "<script>
                alert('Erro ao inserir requisição.');
                window.location.href = 'index.php';
                </script>";
            }
        } else {
            registrarLog('ERRO - Efetuar Requisição', "Erro ao inserir requisição: " . $conn->error);
            echo "<script>
            alert('Erro ao inserir requisição: " . $conn->error . "');
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

    // Obtém o ID do item com base no nome
    $sql_item = "SELECT ID_Item FROM item WHERE NomeItem = '$item'";
    $result_item = $conn->query($sql_item);
    if ($result_item->num_rows > 0) {
        $row_item = $result_item->fetch_assoc();
        $item_id = $row_item['ID_Item'];
    } else {
        registrarLog('ERRO - Editar Requisição', "Item $item não encontrado!!");
        echo "<script>
        alert('Item não encontrado.');
        window.location.href = 'index.php';
        </script>";
        exit();
    }

    // Verifica a quantidade disponível do item
    $sql_quantidade_disponivel = "SELECT Quantidade FROM item WHERE ID_Item = '$item_id'";
    $result_quantidade_disponivel = $conn->query($sql_quantidade_disponivel);

    if ($result_quantidade_disponivel->num_rows > 0) {
        $row_quantidade_disponivel = $result_quantidade_disponivel->fetch_assoc();
        $quantidade_disponivel = $row_quantidade_disponivel['Quantidade'];

        // Verifica se a quantidade solicitada é menor ou igual à quantidade disponível
        if ($quantidade > $quantidade_disponivel) {
            registrarLog('ERRO - Editar Requisição', "Quantidade $quantidade excedente ao Estoque do item $item_id!!");
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
        registrarLog('SUCESSO - Editar Requisição', "Requisição $id_solicitacao editada com sucesso.");
        echo "<script>
        alert('Dados atualizados com sucesso.');
        window.location.href = 'index.php';
        </script>";
    } else {
        registrarLog('ERRO - Editar Requisição', "Erro ao atualizar requisição: " . $conn->error);
        echo "<script>
        alert('Erro ao atualizar a requisição: " . $conn->error . "');
        window.location.href = 'index.php';
        </script>";
    }

    // Fechar a conexão com o banco de dados
    $conn->close();
}
?>
