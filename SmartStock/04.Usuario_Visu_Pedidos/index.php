<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../src/css/reset.css">
    <link rel="stylesheet" href="../src/css/font.css">
    <link rel="stylesheet" href="../src/css/printParametre.css">
    <script src="../src/js/imprimir.js"></script>
    <title>Document</title>

</head>

<?php

    session_start();
    $atual = $_SESSION['matricula'];

    include '../src/db/db_connection.php';

    // Verifica se o usuário está logado
    if (!isset($atual)) {
        header("Location: ../00.Login/index.php");
        exit();
    }
?>
<body>
    <nav>
        <ul>
            <?php
            // Array de itens do menu
                $menu_items = array(
                $atual => "ID.php",
                "Inicio" => "../03.Usuario_Inicial_Solicitação/index.php",
                "Meus Pedidos" => "../04.Usuario_Visu_Pedidos/index.php",
                "Sair" => "../src/php/sair.php"            );

            // Gera links de navegação 
            foreach ($menu_items as $label => $url) {
                if ($label == $atual) {
                    echo '<li>' . $label . '</li>';
                } else {
                    echo '<li><a href="' . $url . '">' . $label . '</a></li>';
                }
            }

            $statusSolic =''; //iniciando var para utilização no select
            ?>
        </ul>
    </nav>
    <div class="content">
        
        <div class="menuLateral">
        <h4>Filtro</h4>
        <form action="" method="get">
            <div>    
                <label for="idSolicitacao">ID Solicitação</label>
                <input type="number" name="idSolicitacao" id="idSolicitacao" value="<?php echo isset($_GET['idSolicitacao']) ? $_GET['idSolicitacao'] : ''; ?>">
            </div>
            <div>
                <label for="itemSolicitado">Item Solicitado</label>
                <input type="text" name="itemSolicitado" id="itemSolicitado" value="<?php echo isset($_GET['itemSolicitado']) ? $_GET['itemSolicitado'] : ''; ?>">
            </div>
            <div>
                <label for="quantidade">Quantidade Solicitada</label>
                <input type="number" name="quantidade" id="quantidade" value="<?php echo isset($_GET['quantidade']) ? $_GET['quantidade'] : ''; ?>">
            </div>
            <div>
                <label for="statusSolicitacao">Status</label>
                <select name="statusSolicitacao" id="statusSolicitacao">
                    <option value="">Selecione o Status</option>
                    <option value="ABERTA" <?php echo ($statusSolic === 'ABERTA') ? 'selected' : ''; ?>>ABERTA</option>
                    <option value="APROVADA" <?php echo ($statusSolic === 'APROVADA') ? 'selected' : ''; ?>>APROVADA</option>
                    <option value="RECUSADA" <?php echo ($statusSolic === 'RECUSADA') ? 'selected' : ''; ?>>RECUSADA</option>
                    <option value="FINALIZADA" <?php echo ($statusSolic === 'FINALIZADA') ? 'selected' : ''; ?>>FINALIZADA</option>
                </select>
            </div>
            
            <div>
                <label for="dataRet">Data Retirada</label>
                <input type="date" name="dataRet" id="dataRet" value="<?php echo isset($_GET['dataRet']) ? $_GET['dataRet'] : ''; ?>">
            </div>
            <div class="relatorio">
                <button type="button" onclick="imprimirRelatorio()">Relátorio</button>
            </div>
            <div class="pesquisa">
                <button type="submit">Pesquisar</button>
            </div>
        </form>
        </div>

        <div class="dataGrid printableArea">
            <table>
                <thead>
                    <tr>
                    <th>ID Solicitação</th>
                    <th>Item Solicitado</th>
                    <th>QTD SOLICITADO</th>
                    <th>Status</th>
                    <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $idSolicitacao = isset($_GET['idSolicitacao']) ? $_GET['idSolicitacao'] : '';
                    $itemSolicitado = isset($_GET['itemSolicitado']) ? $_GET['itemSolicitado'] : '';
                    $quantidade = isset($_GET['quantidade']) ? $_GET['quantidade'] : '';
                    $statusSolic = isset($_GET['statusSolicitacao']) ? $_GET['statusSolicitacao'] : '';
                    $dataRet = isset($_GET['dataRet']) ? $_GET['dataRet'] : '';


                    // Construção da consulta SQL dinâmica
                    $sql = "SELECT ID_Solicitacao, NomeItem, QuantidadeItem, StatusSolicitacao, DataSolicitacao
                            FROM requisicao
                            WHERE FK_CONTA_Matricula = '$atual'";

                    if(!empty($idSolicitacao)){
                        $sql .= " AND ID_Solicitacao = '$idSolicitacao'";
                    }
                    if(!empty($itemSolicitado)){
                        $sql .= " AND NomeItem = '$itemSolicitado'";
                    }
                    if(!empty($quantidade)){
                        $sql .= " AND QuantidadeItem = '$quantidade'";
                    }
                    if(!empty($statusSolic)){
                        $sql .= " AND StatusSolicitacao = '$statusSolic'";
                    }
                    if(!empty($dataRet)){
                        $sql .= " AND DataSolicitacao = '$dataRet'";
                    }


                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Iterar sobre os resultados e exibir as linhas da tabela
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['ID_Solicitacao']}</td>
                                    <td>{$row['NomeItem']}</td>
                                    <td>{$row['QuantidadeItem']}</td>
                                    <td>{$row['StatusSolicitacao']}</td>
                                    <td>{$row['DataSolicitacao']}</td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Nenhum registro encontrado</td></tr>";
                    }

                    // Fechar a conexão com o banco de dados
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>