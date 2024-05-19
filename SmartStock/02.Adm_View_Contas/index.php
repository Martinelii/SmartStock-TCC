<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../src/css/reset.css">
    <link rel="stylesheet" href="../src/css/font.css">
    <title>Document</title>
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
    <div class="content">
        
        <div class="menuLateral">   
        <h4>Filtro</h4> 
            <div>    
                <label for="matricula">Matricula</label>
                <input type="number" name="matricula" id="matricula">
            </div>
            <div>
                <label for="cargo">Cargo</label>
                <input type="text" name="cargo" id="cargo">
            </div>
            <div>
                <label for="setor">Setor</label>
                <input type="text" name="setor" id="setor">
            </div>
            <div>
                <label for="funcao">Função</label>
                <input type="text" name="funcao" id="funcao">
            </div>
            <div>
                <label for="status">Status</label>
                <input type="text" name="status" id="status">
            </div>
            <div class="relatorio">
                <button>Relátorio</button>
            </div>
            <div class="pesquisa">
                <button>Pesquisar</button>
            </div>
        </div>

        <div class="dataGrid">
            <table>
                <thead>
                    <tr>
                        <th>Matricula</th>
                        <th>Email</th>
                        <th>Senha</th>
                        <th>Cargo</th>
                        <th>Setor</th>
                        <th>Função</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
