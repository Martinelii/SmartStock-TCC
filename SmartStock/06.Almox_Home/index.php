<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="../src/css/reset.css">
    <link rel="stylesheet" href="../src/css/font.css">
    <link rel="stylesheet" href="style.css">

</head>
<body>

<nav>
    <ul>
        <?php
        // Array de itens do menu
        $menu_items = array(
            "20240406001" => "ID.php",
            "Inicio" => "../06.Almox_Home/index.php",
            "Cadastra Item" => "../07.Almox_Cadastro_Item/index.php",
            "Estoque" => "../09.Almox_Estoq_Item/index.php",
            "Movimentações" => "../08.Almox_Estoq_Mov/index.php",
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
                <label for="id_item">ID:</label>
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
        <button type="submit" name="confirmar">Concluir</button>
    </form>
</div>
<div class="container">
    <h2>Solicitações Aprovadas</h2>
    <table>
        <thead>
            <tr>
                <th>ID Solicitação</th>
                <th>Item Solicitado</th>
                <th>QTD SOLICITADO</th>
                <th>Status</th>
                <th>Data</th>
                <th>Selecionar</th>
            </tr>
        </thead>
        <tbody>
            <?php
        
            ?>
        </tbody>
    </table>
</div>
</body>
</html>