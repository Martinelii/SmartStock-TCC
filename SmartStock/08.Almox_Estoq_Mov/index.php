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
                "Inicio" => "../06.Almox_Home/index.php",
                "Cadastra Item" => "../07.Almox_Cadastro_Item/index.php",
                "Estoque" => "../09.Almox_Estoq_Item/index.php",
                "Movimentações" => "../08.Almox_Estoq_Mov/index.php",
                "Sair" => "../src/php/sair.php"
            );

            // Gera links de navegação 
            foreach ($menu_items as $label => $url) {
                if ($label == $atual) {
                    echo '<li>' . $label . '</li>';
                } else {
                    echo '<li><a href="' . $url . '">' . $label . '</a></li>';
                }
            }
            ?>
        </ul>
    </nav>
    <div class="content">
        
        <div class="menuLateral">   
        <h4>Filtro</h4> 
        <form action="" method="get">
            <div>    
                <label for="idSolicitação">ID Solicitação</label>
                <input type="number" name="idSolicitação" id="idSolicitação" value="<?php echo isset($_GET['idSolicitação']) ? $_GET['idSolicitação'] : ''; ?>">
            </div>
            <div>
                <label for="MatriculaSolicitante">Matricula Solicitante</label>
                <input type="text" name="MatriculaSolicitante" id="MatriculaSolicitante" value="<?php echo isset($_GET['MatriculaSolicitante']) ? $_GET['MatriculaSolicitante'] : ''; ?>">
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
                <input type="text" name="statusSolicitacao" id="statusSolicitacao" value="<?php echo isset($_GET['statusSolicitacao']) ? $_GET['statusSolicitacao'] : ''; ?>">
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
                        <th>Matricula Solicitante</th>
                        <th>Item Solicitado</th>
                        <th>QTD SOLICITADO</th>
                        <th>Status</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $conditions = [];
                        if (!empty($_GET['idSolicitação'])) {
                            $idSolicitação = $conn->real_escape_string($_GET['idSolicitação']);
                            $conditions[] = "ID_Solicitacao = '$idSolicitação'";
                        }
                        if (!empty($_GET['MatriculaSolicitante'])) {
                            $MatriculaSolicitante = $conn->real_escape_string($_GET['MatriculaSolicitante']);
                            $conditions[] = "FK_CONTA_Matricula = '$MatriculaSolicitante'";
                        }
                        if (!empty($_GET['itemSolicitado'])) {
                            $itemSolicitado = $conn->real_escape_string($_GET['itemSolicitado']);
                            $conditions[] = "NomeItem LIKE '%$itemSolicitado%'";
                        }
                        if (!empty($_GET['quantidade'])) {
                            $quantidade = $conn->real_escape_string($_GET['quantidade']);
                            $conditions[] = "QuantidadeItem = '$quantidade'";
                        }
                        if (!empty($_GET['statusSolicitacao'])) {
                            $statusSolicitacao = $conn->real_escape_string($_GET['statusSolicitacao']);
                            $conditions[] = "StatusSolicitacao = '$statusSolicitacao'";
                        }
                        if (!empty($_GET['dataRet'])) {
                            $dataRet = $conn->real_escape_string($_GET['dataRet']);
                            $conditions[] = "DATE(DataSolicitacao) = '$dataRet'";
                        }

                        $sql = "SELECT * FROM requisicao";
                        if (count($conditions) > 0) {
                            $sql .= " WHERE " . implode(' AND ', $conditions);
                        }

                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td>{$row['ID_Solicitacao']}</td>
                                    <td>{$row['FK_CONTA_Matricula']}</td>
                                    <td>{$row['NomeItem']}</td>
                                    <td>{$row['QuantidadeItem']}</td>
                                    <td>{$row['StatusSolicitacao']}</td>
                                    <td>{$row['DataSolicitacao']}</td>
                                  </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>Nenhum registro encontrado</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
