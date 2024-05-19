<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../src/css/reset.css">
    <link rel="stylesheet" href="../src/css/font.css">
    <title>Document</title>
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
    <div class="content">
        
        <div class="menuLateral">   
        <h4>Filtro</h4> 
            <div>    
                <label for="idItem">ID</label>
                <input type="number" name="idItem" id="idItem">
            </div>
            <div>
                <label for="item">Item</label>
                <input type="text" name="item" id="item">
            </div>

            <div class="relatorio">
                <button>Relátorio</button>
            </div>
            <div class="pesquisa">
                <button>Pesquisar</button>
            </div>
        </div>

        <div class="dataGrid">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Item</th>
                        <th>QTD</th>
                        <th>Data Recebimento</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
