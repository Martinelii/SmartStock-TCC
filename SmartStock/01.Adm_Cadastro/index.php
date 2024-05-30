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
            session_start();
            include '../src/db/db_connection.php';
            $atual = $_SESSION['matricula'];

            // Verifica se o usuário está logado
            if (!isset($atual)) {
                header("Location: ../00.Login/index.php");
                exit();
            }

            // Array de itens do menu
            $menu_items = array(
                $atual => "ID.php",
                "Inicio" => "../01.Adm_Cadastro/index.php",
                "Contas" => "../02.Adm_View_Contas/index.php",
                "Sair" => "../src/sair.php"
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
                    <label for="inpMatricula">Matricula</label>
                    <input class="inpMatricula" type="text" name="inpMatricula" id="inpMatricula" required>
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

    <?php
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
            echo "<script>
            alert('Senhas Incompativeis');
            window.location.href = 'index.php';
            </script>";
            exit();
        }

        // Inserção no banco de dados usando prepared statements
        $sql = "INSERT INTO conta (Email, Senha, Matricula, ContaStatus, FK_DEPARTAMENTO_CodSetor, FK_CARGO_CodCargo) VALUES (?, ?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssssii", $email, $senha, $matricula, $status, $codSetor, $codCargo);

            try {
                if ($stmt->execute()) {
                    echo "<script>
                    alert('Cadastro Efetuado com Sucesso');
                    window.location.href = 'index.php';
                    </script>";
                } else {
                    throw new Exception("Erro ao executar o comando SQL");
                }
            } catch (Exception $e) {
                echo "<script>
                alert('ERRO DURANTE CADASTRO. Por favor, se os campos foram inseridos corretamente.');
                window.location.href = 'index.php';
                </script>";
            }

            $stmt->close();
        } else {
            echo "<script>
            alert('ERRO AO PREPARAR COMANDO SQL. Por favor, tente novamente.');
            window.location.href = 'index.php';
            </script>";
        }

        $conn->close();
    }
    ?>

    <script src="/SmartStock/src/js/index.js"></script>
</body>
</html>
