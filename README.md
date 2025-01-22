
# SmartStock


**SmartStock** é um sistema de gerenciamento de estoque com ênfase em segurança da informação, desenvolvido como Trabalho de Conclusão de Curso (TCC). Ele foi projetado para pequenas e médias empresas, oferecendo controle eficiente, auditorias simplificadas e prevenção de fraudes.

![HTML Badge](https://img.shields.io/badge/HTML-red) ![CSS Badge](https://img.shields.io/badge/CSS-blue) ![JavaScript Badge](https://img.shields.io/badge/JavaScript-yellow) ![PHP Badge](https://img.shields.io/badge/PHP-mediumslateblue) ![MariaDB Badge](https://img.shields.io/badge/MariaDB-mediumpurple)


## Funcionalidades Principais


-   Controle de entrada e saída de itens.
-   Cadastro e gerenciamento de usuários, itens e requisições.
-   Sistema de auditoria com registro detalhado de movimentações.
-   Relatórios dinâmicos para análise de inventário.
-   Implementação de medidas de segurança baseadas na Lei Sarbanes-Oxley (SOx).


## Stack Utilizada


**Frontend**

-   **HTML**: Estruturação do conteúdo.
-   **CSS**: Estilização e layout responsivo.
-   **JavaScript**: Interatividade e validação.

**Backend**

-   **PHP**: Processamento no servidor e integração com o banco de dados.

**Banco de Dados**

-   **MariaDB**: Armazenamento e gerenciamento dos dados.


## Executando Localmente


### Pré-requisitos

-   **XAMPP** ou outro servidor web com suporte a PHP e MariaDB.
-   Editor de código, como **Visual Studio Code** ou **Notepad++***.
-   Navegador atualizado, como **Google Chrome** ou **Mozilla Firefox**.
-   **DBeaver Community** (opcional para gerenciar o banco de dados visualmente).


### Passos para Configuração

1.  **Clone o repositório**  

    Baixe o código-fonte para seu ambiente local:

	```bash
	git clone https://github.com/Martinelii/SmartStock-TCC.git
	```

2.  **Configure o ambiente local**

    -   Copie os arquivos para o diretório do servidor local (ex.: `htdocs` no XAMPP).
    -   Ative o Apache e o MariaDB no painel do XAMPP.

3.  **Configure o banco de dados**

    #### Usando o **phpMyAdmin**:

    -   Acesse o **phpMyAdmin** pelo navegador (ex.: `http://localhost/phpmyadmin`).
    -   Crie um banco de dados chamado `smartstock_db`.
    -   Importe o arquivo `database/db_tcc.sql`.

    #### Usando o **DBeaver Community**:

    -   Abra o **DBeaver** e clique em **Nova Conexão**.
    -   Escolha **MariaDB** na lista de drivers.
    -   Configure os parâmetros:
        -   **Host**: `localhost`
        -   **Porta**: `3306`
        -   **Usuário**: `root`
        -   **Senha**: (deixe em branco, se não configurou uma senha).
    -   Clique em **Testar Conexão** e finalize.
    -   Na aba de conexões, clique com o botão direito sobre a conexão criada, selecione **Executar Script SQL**, e importe o arquivo `database/db_tcc.sql`.

4.  **Configure o sistema**  
    
    No arquivo `config.php`, configure os parâmetros de acesso ao banco de dados:

	```php
	define('DB_HOST', 'localhost');
	define('DB_NAME', 'smartstock_db');
	define('DB_USER', 'root');
	define('DB_PASS', '');
	```

5.  **Acesse o sistema no navegador**  
Após configurar tudo, abra o navegador e acesse:

	```url
	http://localhost/SmartStock-TCC
	```

6.  **Teste as funcionalidades**

-   Faça login utilizando as credenciais padrão incluídas no banco de dados.
-   Explore as telas de cadastro, requisição e auditoria.


## Deploy


Para implantar o sistema em um servidor de produção:

1.  Configure um servidor com suporte a PHP 7.4+ e MariaDB.
2.  Suba os arquivos do projeto para o diretório público do servidor.
3.  Proteja o arquivo `config.php` de acessos não autorizados.
4.  Configure um certificado SSL para comunicação segura (HTTPS).


## Dicas Adicionais


-   Use **DBeaver Community** para gerenciar o banco de dados de forma intuitiva.
-   Verifique os logs do Apache e do banco de dados para reportar possíveis erros.
-   Mantenha backups regulares do banco de dados durante o desenvolvimento.
