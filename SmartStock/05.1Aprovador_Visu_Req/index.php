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
$setor_session = $_SESSION['nomeSetor'];

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
                "Inicio" => "../05.Aprovador_Inicial_Aprovar/index.php",
                "Requisições" =>"../05.1Aprovador_Visu_Req/index.php",
                "Sair" => "../00.Login/index.php"
            );

            // Gera links de navegação 
            foreach ($menu_items as $label => $url) {
                echo '<li><a href="' . $url . '">' . $label . '</a></li>';
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
                    <label for="MatriculaSolicitante">Matrícula Solicitante</label>
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
                <div class="relatorio">
                    <button type="button" onclick="imprimirRelatorio()">Relatório</button>
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
                        <th>Matrícula Solicitante</th>
                        <th>Item Solicitado</th>
                        <th>QTD</th>
                        <th>Status</th>
                        <th>Cargo</th>
                        <th>Setor</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                // Inicializa a query SQL base
                $sql = "SELECT ID_Solicitacao, NomeItem, QuantidadeItem, StatusSolicitacao, CargoFuncionario, SetorFuncionario, FK_CONTA_Matricula
                        FROM requisicao
                        WHERE SetorFuncionario = '$setor_session'";

                // Adiciona os filtros conforme os inputs fornecidos pelo usuário
                if (isset($_GET['idSolicitação']) && $_GET['idSolicitação'] !== '') {
                    $idSolicitacao = $_GET['idSolicitação'];
                    $sql .= " AND ID_Solicitacao = '$idSolicitacao'";
                }
                if (isset($_GET['MatriculaSolicitante']) && $_GET['MatriculaSolicitante'] !== '') {
                    $matriculaSolicitante = $_GET['MatriculaSolicitante'];
                    $sql .= " AND FK_CONTA_Matricula LIKE '%$matriculaSolicitante%'";
                }
                if (isset($_GET['itemSolicitado']) && $_GET['itemSolicitado'] !== '') {
                    $itemSolicitado = $_GET['itemSolicitado'];
                    $sql .= " AND NomeItem LIKE '%$itemSolicitado%'";
                }
                if (isset($_GET['quantidade']) && $_GET['quantidade'] !== '') {
                    $quantidade = $_GET['quantidade'];
                    $sql .= " AND QuantidadeItem = '$quantidade'";
                }
                if (isset($_GET['statusSolicitacao']) && $_GET['statusSolicitacao'] !== '') {
                    $statusSolicitacao = $_GET['statusSolicitacao'];
                    $sql .= " AND StatusSolicitacao LIKE '%$statusSolicitacao%'";
                }

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Iterar sobre os resultados e exibir as linhas da tabela
                    while ($row = $result->fetch_assoc()) {
                        $id_solicitacao = $row['ID_Solicitacao'];
                        $matricula_funcionario = $row['FK_CONTA_Matricula'];
                        $item = $row['NomeItem'];
                        $quantidade = $row['QuantidadeItem'];
                        $status = $row['StatusSolicitacao'];
                        $cargo = $row['CargoFuncionario'];
                        $setor = $row['SetorFuncionario'];

                        echo "<tr>
                                <td>{$id_solicitacao}</td>
                                <td>{$matricula_funcionario}</td>
                                <td>{$item}</td>
                                <td>{$quantidade}</td>
                                <td>{$status}</td>
                                <td>{$cargo}</td>
                                <td>{$setor}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Nenhum registro encontrado</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
