<!DOCTYPE html>
<html lang="pt-BR">

<?php
echo "TESTE";
include '../src/db/db_connection.php';
session_start();

if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $senha = $_POST['password'];

    $sql = "SELECT c.email, c.senha, c.matricula, c.FK_CARGO_CodCargo, c.FK_DEPARTAMENTO_CodSetor, c.contastatus AS contastatus,
    cr.Cargo AS cargo_nome, cr.Funcao AS cargo_funcao, d.Setor AS setor_nome
    FROM conta c
    JOIN cargo cr ON c.FK_CARGO_CodCargo = cr.CodCargo
    JOIN departamento d ON c.FK_DEPARTAMENTO_CodSetor = d.CodSetor
    WHERE c.email='$email' AND c.senha='$senha'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Adicionando Elementos diretamente à sessão
        while($row = $result->fetch_assoc()) {
            $_SESSION['email'] = $row["email"];
            $_SESSION['senha'] = $row["senha"];
            $_SESSION['status'] = $row["contastatus"];
            $_SESSION['matricula'] = $row["matricula"];
            $_SESSION['codCargo'] = $row["FK_CARGO_CodCargo"];
            $_SESSION['codSetor'] = $row["FK_DEPARTAMENTO_CodSetor"];
            $_SESSION['nomeCargo'] = $row['cargo_nome'];
            $_SESSION['cargoFuncao'] = $row['cargo_funcao'];
            $_SESSION['nomeSetor'] = $row['setor_nome'];
        }

        if($_SESSION['status'] === 'Inativo'){
            echo "Conta de Usuario Desativada";

        }
        else{
            // Redirecionamento com base no cargo e setor
            if ($_SESSION['cargoFuncao'] === 'APROVADOR' && $_SESSION['nomeSetor'] != 'Almoxarifado') {
                // Redireciona para a página do aprovador
                header("Location: ../05.Aprovador_Inicial_Aprovar/index.php");
            } elseif (strtolower($_SESSION['nomeSetor']) === 'almoxarifado') {
                // Redireciona para a página do almoxarife
                header("Location: ../06.Almox_Home/index.php");
            } else {
                // Redireciona para uma página padrão ou exibe uma mensagem de erro
                header("Location: ../03.Usuario_Inicial_Solicitação/index.php");
            }
            exit();
        }

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
                <div class="input">
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
