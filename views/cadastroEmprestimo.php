<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Funcionário</title>
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
          integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../assets/css/cadastroEmprestimo.css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="../assets/css/nav.css" media="screen"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
<?php
    require __DIR__ . "/../Controllers/verifyLoginController.php";
    require_once  __DIR__ . "/../autoload.php";

    require __DIR__ . "./components/nav.php";

    $today = new DateTime();
?>
<main>
    <section class="searchSection">
        <h4>Clique aqui para selecionar um aluno:</h4>
        <div class="myBtn register-btn">
            <a class="full" href="./alunos.php?selectMode=true">
                <img class="btnIcon" src="../assets/img/btnStudent.png"/>
            </a>
        </div>
    </section>
    <div class="verticalLine"></div>
    <section class="searchSection">
        <h4>Clique aqui para selecionar um livro:</h4>
        <div class="myBtn register-btn">
            <a class="full" href="./livros.php?selectMode=true">
                <img style="width: 90%;" class="btnIcon" src="../assets/img/btnBook.png"/>
            </a>
        </div>
    </section>
    <div class="verticalLine"></div>
    <form class="loanSection" action="../Controllers/newLoanController.php" method="post">
        <h5>Preencha os Dados do Empréstimo:</h5>
        <div class="inputGroup">
            <input id="loanDate" class="inputUser" type="date" name="loanDate" value="<?= $today->format('Y-m-d') ?>" required>
            <label id="labelLoanDate" class="labelInput" for="loanDate">Data do Empréstimo</label>
        </div>
        <div class="inputGroup">
            <input id="expectedReturnDate" class="inputUser" type="date" name="expectedReturnDate"  required>
            <label id="labelExpectedReturnDate" class="labelInput" for="expectedReturnDate">Data Prevista de Retorno do Empréstimo</label>
        </div>
        <div class="inputGroup">
            <textarea id="obs" name="obs" rows="5" cols="40" maxlength="255"></textarea>
            <label class="labelInput" for="obs">Observação:</label>
        </div>
        <input type="submit" name="submit" id="cadastrarBtn" value="CADASTRAR LIVRO">
    </form>
</main>

<script crossorigin="anonymous"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
