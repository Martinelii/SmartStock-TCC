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

    if (isset($_POST['submit'])){

        $matricula = $_POST['matricula'];
        $item = $_POST['item'];
        $quantidade = $_POST['qtd'];
        $dataRecebimento = $_POST['recebimento'];

        $sql = "INSERT INTO item (NomeItem, Quantidade, DataRecebimento) VALUES ('$item', '$quantidade', '$dataRecebimento')";

        
        if ($conn->query($sql) === TRUE) {
            echo "Cadastro realizado com sucesso!";
        } else {
            echo "Erro ao cadastrar: " . $conn->error;
        }
    
        $conn->close();
    }



?>
<body>
    <nav>
        <ul>
            <?php
            // Array de itens do menu
            $menu_items = array(
                $atual => "ID.php",
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
                    <input class="matricula" type="text" name="matricula" id="matricula" value='<?php echo $atual;?>' required readonly>
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
</body>
</html>