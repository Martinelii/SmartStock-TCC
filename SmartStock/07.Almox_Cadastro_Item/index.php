<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../src/css/reset.css">
    <link rel="stylesheet" href="../src/css/font.css">
    <link rel="stylesheet" href="style.css">

    <title>Smart Stock - Cadastro</title>
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
        <div class="boxform">
            <header>Cadastrar de Item</header>
            <form action="" method="post">
                <div class="input ">
                    <label  for="matricula">Matricula</label>
                    <input class="matricula" type="text" name="matricula" id="matricula" required readonly> 
                </div>
                <div class="input ">
                    <label for="item">Item</label>
                    <input type="text" name="item" id="item" required>
                </div>
                <div class="input ">
                    <label for="qtd">Quantidade</label>
                    <input type="number" name="qtd" id="qtd" required>
                </div>
                <div class="input ">
                    <label for="recebimento">Recebimento</label>
                    <input type="date" name="recebimento" id="recebimento" required>
                </div>
        
                <div class="input">
                    <input type="submit" class="btn" name="submit" value="Cadastrar Item" required>
                </div>
            </form>
        </div>
    </div>

    <script src="/SmartStock/src/js/index.js"></script>
</body>
</html>