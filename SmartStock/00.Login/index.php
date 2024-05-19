<!DOCTYPE html>
<html lang="pt-BR">

<?php
include '../src/db/db_connection.php';


if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $senha = $_POST['password'];

    $sql = "SELECT * FROM conta WHERE Email='$email' AND Senha='$senha'";
    

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Usuário encontrado, você pode redirecioná-lo para a página principal, por exemplo
        while($row = $result->fetch_assoc()) {
            $email = $row["email"];
            $senha = $row["senha"];
            $matricula = $row["matricula"];
            $codCargo = $row["FK_CARGO_CodCargo"];
            $codSetor = $row["FK_DEPARTAMENTO_CodSetor"];
        }
        header("Location: ../01.Adm_Cadastro/index.php");

        exit();
    } else {
        // Usuário não encontrado ou senha incorreta, você pode exibir uma mensagem de erro
        echo "Usuário não encontrado ou senha incorreta.";
    }
}




?>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login - SmartStock</title>

       
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="../src/css/reset.css">
        <link rel="stylesheet" href="../src/css/font.css">
        
    </head>
    <nav>
        <h4>SmartStock</h4>
    </nav>
    <body>
        <div class="container">
            <div class="boxform">
                <header>Login</header>
                <form action="" method="post">
                    <div class="input ">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" required>
                    </div>

                    <div class="input">
                        <label for="password">Senha</label>
                        <input type="password" name="password" id="password" required>
                    </div>

                    <div class="input">
                        <input type="submit" class="btn" name="submit" value="Login" required>
                    </div>
                </form>
            </div>
        </div>

        <script src="/SmartStock/src/js/index.js"></script>
    </body>
</html>