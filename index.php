    <?php
        session_start();

        require "./config.php";

    ?>

    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="imgs/IconKaeru.png">
        <title>Sistema Administrativo - Kaeru</title>

        <base href="http://localhost:8080/PROJETO3BIM/">


        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;
        1,14..32,100..900&display=swap" rel="stylesheet">


        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

        <link rel="stylesheet" href="css/sweetalert2.min.css">
        <link rel="stylesheet" href="css/style.css">

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

        <script src="js/sweetalert2.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="js/parsley.min.js"></script>
        <script src="js/jquery.inputmask.min.js"></script>
        <script src="js/bindings/inputmask.binding.js"></script>

        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <link href="css/summernote-bs5.min.css" rel="stylesheet">
        <script src="js/summernote-bs5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

        <script>
            function mensagem(mensagem, tipo, link = null) {
            Swal.fire({
                 icon: tipo,
                 title: mensagem,
                 confirmButtonText: "OK",
            }).then(() => {
                if (link !== null) {
                location.href = link;
                }
            });
        }
        </script>

    </head>
    <body>
    <?php
        //verificar se está logado e se está sendo enviado dados - verificação dos dados
        //verificar se estar logado - mostro a tela de login
        //se está logado - mostrar a homepage

        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //verificação se user e senha são válidos

            //recuperar as variaveis email e senha
            $email = trim($_POST["email"] ?? NULL);
            $senha = trim($_POST["senha"] ?? NULL);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "<script>mensagem('E-Mail inválido', 'error');</script>";
                require "pages/login.php";
                exit;
            } else if (strlen($senha) < 4 || empty($senha)) {
                echo "<script>mensagem('Senha inválida', 'error');</script>";
                require "pages/login.php";
                exit;
            }

            $sqlLogin = "select id, nome, email, senha from usuario
                where ativo = true
                and email = :email
                limit 1";

            $consultaLogin = $pdo->prepare($sqlLogin);
            $consultaLogin->bindParam(":email", $email);
            $consultaLogin->execute();

            $dadosLogin = $consultaLogin->fetch(PDO::FETCH_OBJ);

            if(empty($dadosLogin->id)) {
                echo "<script>mensagem('Login inválido', 'error');</script>";
                require "pages/login.php";
                exit;
            } else if ($senha != $dadosLogin->senha) {
                echo "<script>mensagem('Login inválido', 'error');</script>";
                require "pages/login.php";
                exit;
        }

            // registrar a sessao

            $_SESSION["kaeru"] = array(
                "id" => $dadosLogin->id,
                "nome" => $dadosLogin->nome
            );

            //redirecionar a página
            echo "<script>location.href='index.php';</script>";


        } else if (!isset($_SESSION["kaeru"])) {
            //tela de login
            require "pages/login.php";
        } else {
            //mostrar tela do sistema interno
            ?>
                    <nav class="navbar navbar-expand-lg bg-body-tertiary">
                            <div class="container-fluid">
                                <a class="navbar-brand" href="#">
                                    <img src="imgs/logoKaeru.png" alt="kaeru" width="100px">
                                </a>
                                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                                </button>
                                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                    <li class="nav-item">
                                    <a class="nav-link" href="index.php">Home</a>
                                    </li>

                                    <li class="nav-item">
                                    <a class="nav-link" href="cadastrar/categoria">Categoria</a>
                                    </li>

                                    <li class="nav-item">
                                    <a class="nav-link" href="cadastrar/estoque">Estoque</a>
                                    </li>

                                    <li class="nav-item">
                                    <a class="nav-link" href="cadastrar/produto">Produto</a>
                                    </li>
                                </ul>
                                    <div class="dropdown">
                                        <button class="btn btn-warning dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Olá <?= $_SESSION["kaeru"]["nome"] ?>
                                        </button>
                                 <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="sair">Sair</a></li>
                                </ul>
                            </div>
                        </div>
                                
                    </div>
                </nav>
                <?php
$param = explode("/", $_GET["param"] ?? "");


$pasta = $param[0] ?? "";
$arquivo = $param[1] ?? "";


    if ($pasta == "") {
        echo "<div class='container mt-4'>
            <h2>Bem-vindo ao Sistema Administrativo Kaeru</h2>
          </div>";
    }

    else if ($pasta == "cadastrar") {

    $page = true;

    $pagina = "cadastrar/{$arquivo}.php";

    if (file_exists($pagina)) {
        require $pagina;
    } else {
        echo "<div class='container mt-4'>
                <div class='alert alert-danger'>
                    Página não encontrada.
                </div>
              </div>";
    }
    }
                    else if ($pasta == "sair") {
                require "pages/sair.php";
            }
            else {
                echo "<div class='container mt-4'>
                    <div class='alert alert-danger'>
                        Página não encontrada.
                    </div>
                </div>";
            }
        ?>
                <?php
            }
        ?>
    </body>
    </html>