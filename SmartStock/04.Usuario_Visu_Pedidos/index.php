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
<div>
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

</body>
</html>