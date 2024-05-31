<?php
session_start();
include '../src/db/db_connection.php';

if (!isset($_SESSION['matricula'])) {
    header("Location: ../00.Login/index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matricula = $_POST['matricula'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $cargo = $_POST['cargo'];
    $setor = $_POST['setor'];
    $funcao = $_POST['funcao'];
    $status = $_POST['status'];

    // Obter os valores antigos do banco de dados
    $sql_old_values = "SELECT c.Email, c.Senha, cg.Cargo, d.Setor, cg.Funcao, c.ContaStatus
                       FROM conta c
                       INNER JOIN cargo cg ON c.FK_CARGO_CodCargo = cg.CodCargo
                       INNER JOIN departamento d ON c.FK_DEPARTAMENTO_CodSetor = d.CodSetor
                       WHERE c.Matricula = ?";
    $stmt_old_values = $conn->prepare($sql_old_values);
    $stmt_old_values->bind_param("i", $matricula);
    $stmt_old_values->execute();
    $result_old_values = $stmt_old_values->get_result();
    $old_values = $result_old_values->fetch_assoc();

    // Verificar se houve mudanças
    $has_changes = false;
    $senha_change = false;

    if ($old_values['Email'] != $email || 
        $old_values['Cargo'] != $cargo || 
        $old_values['Setor'] != $setor ||  
        $old_values['ContaStatus'] != $status) {
        $has_changes = true;
    }

    if( $old_values['Senha'] != $senha){
        $novoHash = password_hash($senha, PASSWORD_DEFAULT);
        $senha_change = true;
    }

    //Faz Validação para gantir que somente gerente pode ter cargo de aprovador
    if($cargo != 'GERENTE'){
        $funcao = 'NÃO APROVADOR';
    }else{
        $funcao = 'APROVADOR';
    }
    if($senha_change === TRUE){
        $sql_hash = "UPDATE conta SET Senha = ? WHERE Matricula = ?";
        $stmt_hash = $conn->prepare($sql_hash);
        $stmt_hash->bind_param("si", $novoHash, $matricula);
        $stmt_hash->execute();
    }

    if ($has_changes) {
        // Atualizar a tabela conta
        $sql_conta = "UPDATE conta SET Email = ?, Senha = ?, ContaStatus = ? WHERE Matricula = ?";
        $stmt_conta = $conn->prepare($sql_conta);
        $stmt_conta->bind_param("sssi", $email, $senha, $status, $matricula);
        $stmt_conta->execute();

        // Obter os IDs do cargo e setor
        $sql_cargo = "SELECT CodCargo FROM cargo WHERE Cargo = ? AND Funcao = ?";
        $stmt_cargo = $conn->prepare($sql_cargo);
        $stmt_cargo->bind_param("ss", $cargo, $funcao);
        $stmt_cargo->execute();
        $result_cargo = $stmt_cargo->get_result();
        $cargo_id = $result_cargo->fetch_assoc()['CodCargo'];

        $sql_setor = "SELECT CodSetor FROM departamento WHERE Setor = ?";
        $stmt_setor = $conn->prepare($sql_setor);
        $stmt_setor->bind_param("s", $setor);
        $stmt_setor->execute();
        $result_setor = $stmt_setor->get_result();
        $setor_id = $result_setor->fetch_assoc()['CodSetor'];

        // Atualizar as FK na tabela conta
        $sql_update_fk = "UPDATE conta SET FK_CARGO_CodCargo = ?, FK_DEPARTAMENTO_CodSetor = ? WHERE Matricula = ?";
        $stmt_update_fk = $conn->prepare($sql_update_fk);
        $stmt_update_fk->bind_param("iii", $cargo_id, $setor_id, $matricula);
        $stmt_update_fk->execute();

        if ($stmt_conta->affected_rows > 0 && $stmt_update_fk->affected_rows > 0) {
            header("Location: ../02.Adm_View_Contas/index.php?success=1");
        } else {
            header("Location: ../02.Adm_View_Contas/index.php?error=1");
        }

        $stmt_conta->close();
        $stmt_cargo->close();
        $stmt_setor->close();
        $stmt_update_fk->close();
    } else {
        // Nenhuma mudança, apenas fechar o modal
        header("Location: ../02.Adm_View_Contas/index.php?nochange=1");
    }

    $conn->close();
} else {
    header("Location: ../02.Adm_View_Contas/index.php");
    exit();
}
?>
