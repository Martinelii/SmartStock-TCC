<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="../src/css/reset.css">
    <link rel="stylesheet" href="../src/css/font.css">
    <link rel="stylesheet" href="style.css">
    <script src="../src/js/preencherForm.js"></script>
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

<div class="container">
    <h2>Requisição do Item</h2>
    <form method="post" action="processar_requisicao.php">
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
                <label for="cargo">Cargo:</label>
                <input type="text" id="cargo" name="cargo" required readonly>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="setor">Setor:</label>
                <input type="text" id="setor" name="setor" required readonly>
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
        <button type="submit" name="acao" value="APROVADA">Confirmar</button>
        <button type="submit" class="recusar" name="acao" value="RECUSADA">Recusar</button>
    </form>
</div>
<div class="container">
    <h2>Lista de Requisições</h2>
    <table>
        <thead>
            <tr>
                <th>ID Solicitação</th>
                <th>Matricula Solicitante</th>
                <th>Item Solicitado</th>
                <th>QTD</th>
                <th>Status</th>
                <th>Cargo</th>
                <th>Setor</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <?php
                //query SQL para obter as informações (PréPronta para utilização de filtro)
                $sql = "SELECT ID_Solicitacao, NomeItem, QuantidadeItem, StatusSolicitacao, CargoFuncionario, SetorFuncionario, FK_CONTA_Matricula
                        FROM requisicao
                        WHERE SetorFuncionario = '$setor_session' AND StatusSolicitacao = 'ABERTA' AND ID_Solicitacao != '$atual'";

                /*filtro
                
                */

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
                                <td><button type='button' onclick=\"preencherFormulario('{$id_solicitacao}', '{$matricula_funcionario}', '{$cargo}', '{$setor}', '{$item}', '{$quantidade}')\">Selecionar</button></td> 
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
