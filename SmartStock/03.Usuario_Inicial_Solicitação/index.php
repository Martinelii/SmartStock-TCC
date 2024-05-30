<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../src/css/reset.css">
    <link rel="stylesheet" href="../src/css/font.css">
    <link rel="stylesheet" href="style.css">
    <script defer src="../src/js/excluirSolicitacao.js"></script>
    <script defer src="../src/js/preencherForm.js"></script>
</head>
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$atual = $_SESSION['matricula'];
$session_cargo = $_SESSION['nomeCargo'];
$session_setor = $_SESSION['nomeSetor'];

include '../src/db/db_connection.php';
include 'processar_exclusao.php';

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
            "Sair" => "../src/php/sair.php"        );

        // Gera links de navegação 
        foreach ($menu_items as $label => $url) {
            echo '<li><a href="' . $url . '">' . $label . '</a></li>';
        }
        ?>
    </ul>
</nav>

<div class="container">
    <h2>Requisição do Item</h2>
    <form method="post" action="processar_requisicao.php">
        <div class="row">
            <div class="col-12">
                <label for="id_solicitacao">ID Solicitação:</label>
                <input type="text" id="id_solicitacao" name="id_solicitacao" required readonly value="Gerado automaticamente">
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="matricula_funcionario">Matrícula do Funcionário:</label>
                <input type="text" id="matricula_funcionario" name="matricula_funcionario" required readonly value="<?php echo $atual; ?>">
            </div>
            <div class="col-6">
                <label for="cargo">Cargo:</label>
                <input type="text" id="cargo" name="cargo" required readonly value="<?php echo $session_cargo; ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="setor">Setor:</label>
                <input type="text" id="setor" name="setor" required readonly value="<?php echo $session_setor; ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="item">Item:</label>
                <select name="item" id="item" required>
                    <option value="">Selecione um item</option>
                    <?php
                        $item_query = "SELECT NomeItem FROM item";
                        $item_result = $conn->query($item_query);
                        if ($item_result->num_rows > 0) {
                            while ($item_row = $item_result->fetch_assoc()) {
                                echo '<option value="' . $item_row['NomeItem'] . '">' . $item_row['NomeItem'] . '</option>';
                            }
                        } else {
                            echo '<option value="">Nenhum item encontrado</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="col-6">
                <label for="quantidade">Quantidade:</label>
                <input type="number" id="quantidade" name="quantidade" required>
            </div>
        </div>
        <button type="submit" name="submit" id="btnConfirmar" style="display: block;">Confirmar</button>
        <button type="submit" name="editar" id="btnEditar" value='{$id_solicitacao}' style="display: none;">Editar</button>
    </form>
</div>
<div class="container">
    <h2>Lista de Requisições</h2>
    <table>
        <thead>
            <tr>
                <th>ID Solicitação</th>
                <th>Item Solicitado</th>
                <th>QTD SOLICITADO</th>
                <th>Status</th>
                <th>Data</th>
                <th>Editar</th>
                <th>Cancelar</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $sql = "SELECT ID_Solicitacao, NomeItem, QuantidadeItem, StatusSolicitacao, CargoFuncionario, SetorFuncionario, FK_CONTA_Matricula, DataSolicitacao
                        FROM requisicao
                        WHERE FK_CONTA_Matricula = '$atual' AND StatusSolicitacao = 'ABERTA'";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Iterar sobre os resultados e exibir as linhas da tabela                    
                    while ($row = $result->fetch_assoc()) {
                        $id_solicitacao = $row['ID_Solicitacao'];
                        $matricula_funcionario = $atual;
                        $item = $row['NomeItem'];
                        $quantidade = $row['QuantidadeItem'];
                        $status = $row['StatusSolicitacao'];
                        $cargo = $row['CargoFuncionario'];
                        $setor = $row['SetorFuncionario'];
                        $dataSolic = $row['DataSolicitacao'];

                        echo "<tr>
                                <td>{$id_solicitacao}</td>
                                <td>{$item}</td>
                                <td>{$quantidade}</td>
                                <td>{$status}</td>
                                <td>{$dataSolic}</td>
                                <td><button type='button' onclick=\"editarFormulario('{$id_solicitacao}', '{$matricula_funcionario}', '{$cargo}', '{$setor}', '{$item}', '{$quantidade}')\">Alterar</button></td> 
                                <td><button type='button' name='deletar' onclick=\"excluirSolicitacao('{$id_solicitacao}')\">Cancelar</button></td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Nenhum registro encontrado</td></tr>";
                }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
