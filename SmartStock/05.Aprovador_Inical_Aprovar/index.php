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
            "Inicio" => "../05.Aprovador_Inical_Aprovar/index.php",
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
        <button type="submit" name="confirmar">Confirmar</button>
        <button type="submit"  class="recusar" name="recusar">Recusar</button>
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
                <th></th>
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