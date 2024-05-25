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
                "Inicio" => "../01.Adm_Cadastro/index.php",
                "Contas" => "../02.Adm_View_Contas/index.php",
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
        <form method="GET" action="">
            <div>    
                <label for="matricula">Matricula</label>
                <input type="number" name="matricula" id="matricula" value="<?php echo isset($_GET['matricula']) ? $_GET['matricula'] : ''; ?>">
            </div>
            <div>
                <label for="cargo">Cargo</label>
                <select name="cargo" id="cargo">
                    <option value="">Selecione o Cargo</option>
                    <?php
                    $cargo_query = "SELECT DISTINCT Cargo FROM cargo";
                    $cargo_result = $conn->query($cargo_query);
                    while ($cargo_row = $cargo_result->fetch_assoc()) {
                        $selected = (isset($_GET['cargo']) && $_GET['cargo'] == $cargo_row['Cargo']) ? 'selected' : '';
                        echo "<option value='{$cargo_row['Cargo']}' $selected>{$cargo_row['Cargo']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div>
                <label for="setor">Setor</label>
                <select name="setor" id="setor">
                    <option value="">Selecione o Setor</option>
                    <?php
                    $setor_query = "SELECT DISTINCT Setor FROM departamento";
                    $setor_result = $conn->query($setor_query);
                    while ($setor_row = $setor_result->fetch_assoc()) {
                        $selected = (isset($_GET['setor']) && $_GET['setor'] == $setor_row['Setor']) ? 'selected' : '';
                        echo "<option value='{$setor_row['Setor']}' $selected>{$setor_row['Setor']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div>
                <label for="funcao">Função</label>
                <select name="funcao" id="funcao">
                    <option value="">Selecione a Função</option>
                    <?php
                    $funcao_query = "SELECT DISTINCT Funcao FROM cargo";
                    $funcao_result = $conn->query($funcao_query);
                    while ($funcao_row = $funcao_result->fetch_assoc()) {
                        $selected = (isset($_GET['funcao']) && $_GET['funcao'] == $funcao_row['Funcao']) ? 'selected' : '';
                        echo "<option value='{$funcao_row['Funcao']}' $selected>{$funcao_row['Funcao']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div>
                <label for="status">Status</label>
                <select name="status" id="status">
                    <option value="">Selecione o Status</option>
                    <option value="Ativo" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Ativo') ? 'selected' : ''; ?>>Ativo</option>
                    <option value="Inativo" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Inativo') ? 'selected' : ''; ?>>Inativo</option>
                </select>
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
                        <th>Matricula</th>
                        <th>Email</th>
                        <th>Senha</th>
                        <th>Cargo</th>
                        <th>Setor</th>
                        <th>Função</th>
                        <th>Status</th>
                        <th>Alterar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Captura os valores dos filtros
                    $filtroMatricula = isset($_GET['matricula']) ? $_GET['matricula'] : '';
                    $filtroCargo = isset($_GET['cargo']) ? $_GET['cargo'] : '';
                    $filtroSetor = isset($_GET['setor']) ? $_GET['setor'] : '';
                    $filtroFuncao = isset($_GET['funcao']) ? $_GET['funcao'] : '';
                    $filtroStatus = isset($_GET['status']) ? $_GET['status'] : '';

                    // Construção da consulta SQL dinâmica
                    $sql = "SELECT c.Matricula, c.Email, c.Senha, cg.Cargo, d.Setor, cg.Funcao, c.ContaStatus
                            FROM conta c
                            INNER JOIN cargo cg ON c.FK_CARGO_CodCargo = cg.CodCargo
                            INNER JOIN departamento d ON c.FK_DEPARTAMENTO_CodSetor = d.CodSetor
                            WHERE 1=1";

                    if (!empty($filtroMatricula)) {
                        $sql .= " AND c.Matricula = '$filtroMatricula'";
                    }
                    if (!empty($filtroCargo)) {
                        $sql .= " AND cg.Cargo LIKE '%$filtroCargo%'";
                    }
                    if (!empty($filtroSetor)) {
                        $sql .= " AND d.Setor LIKE '%$filtroSetor%'";
                    }
                    if (!empty($filtroFuncao)) {
                        $sql .= " AND cg.Funcao LIKE '%$filtroFuncao%'";
                    }
                    if (!empty($filtroStatus)) {
                        $sql .= " AND c.ContaStatus LIKE '%$filtroStatus%'";
                    }

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Iterar sobre os resultados e exibir as linhas da tabela
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['Matricula']}</td>
                                    <td>{$row['Email']}</td>
                                    <td>{$row['Senha']}</td>
                                    <td>{$row['Cargo']}</td>
                                    <td>{$row['Setor']}</td>
                                    <td>{$row['Funcao']}</td>
                                    <td>{$row['ContaStatus']}</td>
                                    <td><button class='alterar' type='button'>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>Nenhum registro encontrado</td></tr>";
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