<?php
date_default_timezone_set('America/Sao_Paulo');
function registrarLog($acao, $detalhes) {
    $arquivoLog = __DIR__ . '/../logs/acoes.log'; // Usando __DIR__ para obter o Diretorio Completo
    $dataHora = date('Y-m-d H:i:s'); // Data e hora atual
    $matricula = isset($_SESSION['matricula']) ? $_SESSION['matricula'] : 'desconhecido'; //Coleta Mtricula da Sessão, caso não tenha matricula input 'desconhecido' (Registro de Login)

    //usando Var Data e Hora e coletando paramentros: Ação do Botão e Detalhes: ID's, Itens e etc..
    $logEntry = "[$dataHora] Matricula: $matricula - Ação: $acao - Detalhes: $detalhes" . PHP_EOL;

    // Tentativa de escrever no arquivo de log
    if (file_put_contents($arquivoLog, $logEntry, FILE_APPEND) === false) {
        error_log("Falha ao gravar no arquivo de log: $arquivoLog");
    }
}
?>
