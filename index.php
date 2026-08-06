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
                exit;
            } else if (strlen($senha) < 4 || empty($senha)) {
                echo "<script>mensagem('Senha inválida', 'error');</script>";
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
                exit;
            } else if ($senha != $dadosLogin->senha) {
                echo "<script>mensagem('Login inválido', 'error');</script>";
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
                                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                                    </li>
                                    <li class="nav-item">
                                    <a class="nav-link" href="#">Link</a>
                                    </li>
                                    <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Dropdown
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Action</a></li>
                                        <li><a class="dropdown-item" href="#">Another action</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                                    </ul>
                                    </li>
                                    <li class="nav-item">
                                    <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                                    </li>
                                </ul>
                                <a href="pages/logout.php">Sair</a>
                                </div>
                                
                            </div>
                            </nav>
            <?php
        }
    ?>
    </body>
    </html>