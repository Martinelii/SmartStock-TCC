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
    <div class="container">
        <div class="boxform">
            <header>Cadastrar</header>
            <form action="" method="post">
                <div class="input ">
                    <label  for="matricula">Matricula</label>
                    <input  class="matricula" type="text" name="matricula" id="matricula" required>
                </div>
                <div class="input ">
                    <label for="matricula">Email</label>
                    <input type="text" name="email" id="email" required>
                </div>
                <div class="input ">
                    <label for="cargo">Cargo</label>
                    <input type="text" name="cargo" id="cargo" required>
                </div>
                <div class="input ">
                    <label for="cargo">Setor</label>
                    <input type="text" name="setor" id="setor" required>
                </div>
                
                <div class="input">
                    <label for="funcao">Função</label>
                    <select name="funcao" id="funcao">
                        <option value="naoAprovador">Não Aprovador</option>
                        <option value="aprovador">Aprovador</option>
                    </select>
                </div>

                <div class="input">
                    <label for="password">Senha</label>
                    <input type="password" name="password" id="password" title="senha" required>
                </div>
                <div class="input">
                    <label for="password">Confirmação Senha</label>
                    <input type="password" name="confirpassword" id="confirpassword" title="confirmação senha" required>
                </div>





                <div class="input">
                    <input type="submit" class="btn" name="submit" value="Cadastrar" required>
                </div>
            </form>
        </div>
    </div>

    <script src="/SmartStock/src/js/index.js"></script>
</body>
</html>