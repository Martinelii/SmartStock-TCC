<?php
function realizarLogin($email, $senha, $conn) {

    $sql = "SELECT c.email, c.senha, c.matricula, c.FK_CARGO_CodCargo, c.FK_DEPARTAMENTO_CodSetor, c.contastatus AS contastatus,
    cr.Cargo AS cargo_nome, cr.Funcao AS cargo_funcao, d.Setor AS setor_nome
    FROM conta c
    JOIN cargo cr ON c.FK_CARGO_CodCargo = cr.CodCargo
    JOIN departamento d ON c.FK_DEPARTAMENTO_CodSetor = d.CodSetor
    WHERE c.email='$email'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Obtenha os dados do usuário
        $row = $result->fetch_assoc();
        
        // Verifique se a conta está ativa
        if ($row["contastatus"] === 'Inativo') {
            echo "Conta de usuário desativada.";
            return false;
        }
        
        // Verifique se a senha fornecida corresponde ao hash armazenado
        if (password_verify($senha, $row["senha"])) {
            // Inicie a sessão e armazene os dados do usuário
            session_start();
            $_SESSION['email'] = $row["email"];
            $_SESSION['senha'] = $row["senha"];
            $_SESSION['status'] = $row["contastatus"];
            $_SESSION['matricula'] = $row["matricula"];
            $_SESSION['codCargo'] = $row["FK_CARGO_CodCargo"];
            $_SESSION['codSetor'] = $row["FK_DEPARTAMENTO_CodSetor"];
            $_SESSION['nomeCargo'] = $row['cargo_nome'];
            $_SESSION['cargoFuncao'] = $row['cargo_funcao'];
            $_SESSION['nomeSetor'] = $row['setor_nome'];
            
            // Redirecione com base nas permissões do usuário
            if ($_SESSION['cargoFuncao'] === 'APROVADOR' && $_SESSION['nomeSetor'] != 'Almoxarifado') {
                header("Location: ../05.Aprovador_Inicial_Aprovar/index.php");
            } elseif (strtolower($_SESSION['nomeSetor']) === 'almoxarifado') {
                header("Location: ../06.Almox_Home/index.php");
            } elseif ($_SESSION['codCargo'] === '1' && $_SESSION['cargoFuncao'] != 'APROVADOR') {
                header("Location: ../01.Adm_Cadastro/index.php");
            } else {
                header("Location: ../03.Usuario_Inicial_Solicitação/index.php");
            }
            exit();
        } else {
            return false;
        }
    } else {
        return false;
    }
}
?>
