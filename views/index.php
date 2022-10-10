<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>SAB - Menu</title>
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
          integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" rel="stylesheet">
    <link href="../assets/css/index.css" media="screen" rel="stylesheet" type="text/css"/>
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
<?php
require __DIR__ . "/../Controllers/verifyLoginController.php";
?>
<nav class="navbar navbar-expand-lg navbar bg-white">
    <div class="container-fluid">
        <h1>E.E.B Apolônio Ireno Cardoso</h1>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a aria-expanded="false" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#"
                       role="button">
                        Olá, usuário!
                    </a>
                    <ul class="dropdown-menu dropdown-menu">
                        <li><a class="dropdown-item" href="#">Meus Dados</a></li>
                        <li><a class="dropdown-item" href="#">Relatórios</a></li>
                        <li><a class="dropdown-item" href="#">Gêneros Literários</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main>
    <section id="btnPanel">
        <div id="newLoanBtn">
            <a id="newLoanLink">
                <img alt="" id="newLoanIcon" src="../assets/img/plusIcon.png"/>
                <h4 id="newLoanText">Novo Empréstimo</h4>
            </a>
        </div>
        <div id="rowBtnPanel">
            <div class="btn-column">
                <div class="myBtn register-btn">
                    <a class="full">
                        <img class="btnIcon" src="../assets/img/btnBook.png"/>
                        <h4>Cadastrar <br> Livros</h4>
                    </a>
                </div>
                <div class="myBtn register-btn">
                    <a class="full">
                        <img class="btnIcon" src="../assets/img/btnStudent.png"/>
                        <h4>Cadastrar <br> Alunos</h4>
                    </a>
                </div>
                <div class="myBtn register-btn">
                    <a class="full">
                        <img class="btnIcon" id="workerIcon" src="../assets/img/btnWorker.png"/>
                        <h4>Cadastrar <br> Funcionários</h4>
                    </a>
                </div>
            </div>
            <div id="vertical-line"></div>
            <div class="btn-column">
                <div class="myBtn manage-btn">
                    <a class="full">
                        <img class="manageIcon" src="../assets/img/btnManage.png"/>
                        <h4>Gerenciar <br> Livros</h4>
                    </a>
                </div>
                <div class="myBtn manage-btn">
                    <a class="full">
                        <img class="manageIcon" src="../assets/img/btnManage.png"/>
                        <h4>Gerenciar <br> Alunos</h4>
                    </a>
                </div>
                <div class="myBtn manage-btn">
                    <a class="full">
                        <img class="manageIcon" src="../assets/img/btnManage.png"/>
                        <h4>Gerenciar <br> Funcionários</h4>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <div id="showBtn">
        <a class="full">
            <h2>Empréstimos em Andamento</h2>
        </a>
    </div>
</main>
<script crossorigin="anonymous"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
