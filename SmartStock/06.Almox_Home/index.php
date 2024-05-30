<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="../src/css/reset.css">
    <link rel="stylesheet" href="../src/css/font.css">
    <link rel="stylesheet" href="style.css">

    <script src="../src/js/preencherForm.js"></script>
    <script>
        function preencherFormularioAlmox(id, matricula, idItem, item, quantidade) {
            document.getElementById('id_solicitacao').value = id;
            document.getElementById('matricula_funcionario').value = matricula;
            document.getElementById('id_item').value = idItem;
            document.getElementById('item').value = item;
            document.getElementById('quantidade').value = quantidade;
        }
    </script>

</head>
<body>
<?php
    session_start();
    $atual = $_SESSION['matricula'];
    $setor_session = $_SESSION['nomeSetor'];

    include '../src/db/db_connection.php';
  

    // Verifica se o usuário está logado
    if (!isset($atual)) {
        header("Location: ../00.Login/index.php");
        exit();
    }
?>
<nav>
    <ul>
        <?php
        // Array de itens do menu
        $menu_items = array(
            $atual => "ID.php",
            "Inicio" => "../06.Almox_Home/index.php",
            "Cadastra Item" => "../07.Almox_Cadastro_Item/index.php",
            "Estoque" => "../09.Almox_Estoq_Item/index.php",
            "Movimentações" => "../08.Almox_Estoq_Mov/index.php",
            "Sair" => "../src/sair.php"
        );

        // Gera links de navegação 
        foreach ($menu_items as $label => $url) {
            echo '<li><a href="' . $url . '">' . $label . '</a></li>';
        }
        ?>
    </ul>
</nav>

<div class="container">
    <h2>Requisição do Item</h2>
    <form method="post" action="processar_finalizacao.php">
        <div class="row">
            <div class="col-12">
                <label for="id_solicitacao">ID Solicitação:</label>
                <input type="text" id="id_solicitacao" name="id_solicitacao" required readonly>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="matricula_funcionario">Matrícula do Funcionário:</label>
                <input type="text" id="matricula_funcionario" name="matricula_funcionario" required readonly>
            </div>
            <div class="col-6">
                <label for="id_item">ID Item:</label>
                <input type="text" id="id_item" name="id_item" required readonly>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="item">Item:</label>
                <input type="text" id="item" name="item" required readonly>
            </div>
            <div class="col-6">
                <label for="quantidade">Quantidade:</label>
                <input type="number" id="quantidade" name="quantidade" required readonly>
            </div>
        </div>
        <button type="submit" name="acao" value="FINALIZADA">FINALIZAR</button>
    </form>
</div>
<div class="container">
    <h2>Solicitações Aprovadas</h2>
    <table>
        <thead>
            <tr>
                <th>ID Solicitação</th>
                <th>Matricula Solicitante</th>
                <th>ID Item</th>
                <th>Item Solicitado</th>
                <th>QTD SOLICITADO</th>
                <th>Status</th>
                <th>Data</th>
                <th>Selecionar</th>
            </tr>
        </thead>
        <tbody>
        <?php
                //query SQL para obter as informações (PréPronta para utilização de filtro)
                $sql = "SELECT ID_Solicitacao, NomeItem, QuantidadeItem, StatusSolicitacao, DataSolicitacao, FK_CONTA_Matricula, FK_ITEM_ID_Item
                        FROM requisicao
                        WHERE StatusSolicitacao = 'APROVADA'";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Iterar sobre os resultados e exibir as linhas da tabela
                    while ($row = $result->fetch_assoc()) {
                        $id_solicitacao = $row['ID_Solicitacao'];
                        $matricula_funcionario = $row['FK_CONTA_Matricula'];
                        $idItemSolicitado = $row['FK_ITEM_ID_Item'];
                        $item = $row['NomeItem'];
                        $quantidade = $row['QuantidadeItem'];
                        $status = $row['StatusSolicitacao'];
                        $dataSolicitacao = $row['DataSolicitacao'];

                        echo "<tr>
                                <td>{$id_solicitacao}</td>
                                <td>{$matricula_funcionario}</td>
                                <td>{$idItemSolicitado}</td>
                                <td>{$item}</td>
                                <td>{$quantidade}</td>
                                <td>{$status}</td>
                                <td>{$dataSolicitacao}</td>
                                <td><button type='button' onclick=\"preencherFormularioAlmox('{$id_solicitacao}', '{$matricula_funcionario}', '{$idItemSolicitado}', '{$item}', '{$quantidade}')\">Selecionar</button></td> 
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>Nenhum registro encontrado</td></tr>";
                }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
