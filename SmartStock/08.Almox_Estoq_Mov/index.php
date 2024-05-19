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
                <label for="idSoli">ID Solicitação</label>
                <input type="number" name="idSolicitação" id="idSolicitação">
            </div>
            <div>
                <label for="idSoli">ID Item</label>
                <input type="number" name="idItem" id="idItem">
            </div>
            <div>
                <label for="aprovador">Matricula Aprovador</label>
                <input type="number" name="aprovador" id="aprovador">
            </div>
            <div>
                <label for="solicitante">Matricula Solicitante</label>
                <input type="number" name="solicitante" id="solicitante">
            </div>
            <div>
                <label for="dataRet">Data Retirada</label>
                <input type="date" name="dataRet" id="dataRet">
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
    </div>
</body>
</html>
