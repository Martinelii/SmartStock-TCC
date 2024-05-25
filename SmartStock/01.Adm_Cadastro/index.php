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
include '../src/db/db_connection.php';
$atual = $_SESSION['matricula'];

// Verifica se o usuário está logado
if (!isset($atual)) {
    header("Location: ../00.Login/index.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['matricula'])) {
    // Redireciona de volta para a mesma página
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}
if (isset($_POST['submit'])) {
    $matricula = $_POST['inpMatricula'];
    $email = $_POST['email'];
    $senha = $_POST['password'];
    $confirSenha = $_POST['confirpassword'];
    $codCargo = $_POST['cargo'];
    $codSetor = $_POST['setor'];
    $status = $_POST['status'];

    // Validação básica de senha
    if ($senha != $confirSenha) {
        echo "As senhas não coincidem!";
        exit();
    }

    // Inserção no banco de dados
    $sql = "INSERT INTO conta (Email, Senha, Matricula, ContaStatus, FK_DEPARTAMENTO_CodSetor, FK_CARGO_CodCargo) VALUES ('$email', '$senha', '$matricula', '$status', '$codSetor', '$codCargo')";

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
                "Inicio" => "../01.Adm_Cadastro/index.php",
                "Contas" => "../02.Adm_View_Contas/index.php",
                "Sair" => "../00.Login/index.php" //Criar arquivo para executar a função de fechar sessão e redirecionar para login
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
                    <label  for="inpMatricula">Matricula</label>
                    <input  class="inpMatricula" type="text" name="inpMatricula" id="inpMatricula" required>
                </div>
                <div class="input ">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" required>
                </div>


                <div class="input ">
                    <label for="cargo">Cargo</label>
                    <select name="cargo" id="cargo" required>
                        <?php
                        $cargo_query = "SELECT CodCargo, Cargo FROM cargo";
                        $cargo_result = $conn->query($cargo_query);
                        while ($cargo_row = $cargo_result->fetch_assoc()) {
                            echo '<option value="' . $cargo_row['CodCargo'] . '">' . $cargo_row['Cargo'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="input ">
                    <label for="setor">Setor</label>
                    <select name="setor" id="setor" required>
                        <?php
                        $setor_query = "SELECT CodSetor, Setor FROM departamento";
                        $setor_result = $conn->query($setor_query);
                        while ($setor_row = $setor_result->fetch_assoc()) {
                            echo '<option value="' . $setor_row['CodSetor'] . '">' . $setor_row['Setor'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                

                <div class="input">
                    <label for="status">Status</label>
                    <select name="status" id="status">
                        <option value="Ativo">Ativo</option>
                        <option value="Inativo">Inativo</option>
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