<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="../src/css/reset.css">
    <link rel="stylesheet" href="../src/css/font.css">


    <style>
        nav {
            background-color: #43766c;
            padding: 10px 0;
        }
        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        nav ul li {
            display: inline;
            margin-right: 10px;
        }
        nav ul li a {
            color: #fff;
            text-decoration: none;
            padding: 5px 10px;
        }
        nav ul li a:hover {
            background-color: #555;
        }
        .container {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .container h2 {
            text-align: center;
            color: #333;
        }
        .row {
            margin-bottom: 15px;
        }
        .row::after {
            content: "";
            display: table;
            clear: both;
        }
        .col-6 {
            float: left;
            width: 50%;
        }
        .col-12 {
            float: left;
            width: 100%;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<nav>
    <ul>
        <?php
        // Array de itens do menu
        $menu_items = array(
            "20240406001" => "ID.php",
            "Inicio" => "../03.Usuario_Inicial_Solicitação/index.php",
            "Meus Pedidos" => "../04.Usuario_Visu_Pedidos/index.php",
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
                <input type="text" id="item" name="item" required>
            </div>
            <div class="col-6">
                <label for="quantidade">Quantidade:</label>
                <input type="number" id="quantidade" name="quantidade" required>
            </div>
        </div>
        <button type="submit" name="confirmar">Confirmar</button>
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
            </tr>
        </thead>
        <tbody>
            <?php
        
            ?>
        </tbody>
    </table>
</div>

<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    th, td {
        border: 1px solid #ccc;
        padding: 12px;
        text-align: left;
    }
    th {
        background-color: #43766c;
        color: white;
    }
</style>

</body>
</html>