<!DOCTYPE html>
<html lang="pt-BR">   
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

    <?php
    include '../src/db/db_connection.php';
    include 'validacao.php'; // Inclui o arquivo de validação

    if(isset($_POST['submit'])){
        $email = $_POST['email'];
        $senha = $_POST['password'];

        // Chama a função de validação
        $loginSucesso = realizarLogin($email, $senha, $conn);

        if (!$loginSucesso) {
            // Usuário não encontrado ou senha incorreta
            echo "<script>
            alert('Usuario não encontrado ou Credencias de acesso invalidas!!');
            window.location.href = 'index.php';
            </script>";
        }
    }
    ?>
</body>
</html>
