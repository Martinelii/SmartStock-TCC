<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../src/css/modal.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../src/css/reset.css">
    <link rel="stylesheet" href="../src/css/font.css">
    <link rel="stylesheet" href="../src/css/printParametre.css">
    <script src="../src/js/imprimir.js"></script>
    <script src="modalAdicionar.js"></script>
    <title>Document</title>
</head>

<?php
session_start();
$atual = $_SESSION['matricula'];

include '../src/db/db_connection.php';

// Verifica se o usuário está logado
if (!isset($atual)) {
    header("Location: ../00.Login/index.php");
    exit();
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
                "Sair" => "../src/php/sair.php"
            );

            // Gera links de navegação 
            foreach ($menu_items as $label => $url) {
                echo '<li><a href="' . $url . '">' . $label . '</a></li>';
            }
            ?>
        </ul>
    </nav>
    <div class="content">
        
        <div class="menuLateral">   
            <h4>Filtro</h4> 
            <form action="" method="get">
                <div>    
                        <label for="idItem">ID</label>
                        <input type="number" name="idItem" id="idItem" value="<?php echo isset($_GET['idItem'])? $_GET['idItem']:'';?>">
                    </div>
                    <div>
                        <label for="item">Item</label>
                        <input type="text" name="item" id="item" value="<?php echo isset($_GET['item'])? $_GET['item']:'';?>">
                    </div>

                    <div class="relatorio">
                        <button type="button" onclick="imprimirRelatorio()">Relátorio</button>
                    </div>
                    <div class="pesquisa">
                        <button type="submit">Pesquisar</button>
                    </div>
                </div>
            </form>


            <div class="dataGrid printableArea">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Item</th>
                            <th>QTD</th>
                            <th>Data Recebimento</th>
                            <th>Adicionar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //pegando valores dos filtros
                        $filtroidItem = isset($_GET['idItem']) ? $_GET['idItem'] : '';
                        $filtroItem = isset($_GET['item']) ? $_GET['item'] : '';
                        //query sql
                        $sql = "SELECT * FROM item WHERE 1=1";

                        if(!empty($filtroidItem)){
                            $sql .= " AND ID_Item = $filtroidItem";;
                        } 
                        if(!empty($filtroItem)){
                            $sql .= " AND NomeItem LIKE '%$filtroItem%'";;
                        }


                        $result = $conn->query($sql);

                        if($result->num_rows > 0){

                            while($row = $result->fetch_assoc()){
                                echo "<tr>
                                <td>{$row['ID_Item']}</td>
                                <td>{$row['NomeItem']}</td>
                                <td>{$row['Quantidade']}</td>
                                <td>{$row['DataRecebimento']}</td>
                                <td><button class='adicionar' type='button' onclick='abrirModalAdicionar({$row['ID_Item']})'>Adicionar</button></td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>Nenhum registro encontrado</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
    </div>

    <!-- Modal -->
    <div id="modalAdicionar" class="modal">
        <div class="modal-content">
            <span class="close" onclick="fecharModalAdicionar()">&times;</span>
            <h2>Adicionar/Editar Item</h2>
            <form id="formAdicionarEditar" method="post" action="atualizarItem.php">
                <input type="hidden" name="idItem" id="modalIdItem">
                <div>
                    <label for="modalNomeItem">Nome do Item:</label>
                    <input type="text" name="nomeItem" id="modalNomeItem" readonly>
                </div>
                <div>
                    <label for="modalQuantidade">Quantidade:</label>
                    <input type="number" name="quantidade" id="modalQuantidade" required>
                </div>
                <div>
                    <button type="submit" name="submit">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
