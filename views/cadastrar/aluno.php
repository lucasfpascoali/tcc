<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Aluno</title>
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
          integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../../assets/css/cadastroAluno.css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="../../assets/css/nav.css" media="screen"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
<?php

use Source\Core\Session;

require __DIR__ . "/../../Controllers/login/verifyController.php";
require_once __DIR__ . "/../../autoload.php";


$session = new Session();
$message = $session->flash();


require __DIR__ . "/../components/nav.php";
?>
<main>
    <h2>Preencha os dados do Aluno:</h2>
    <form action="../../Controllers/student/newController.php" method="post">
        <?php
        if ($message) {
            echo $message->render();
        }
        ?>
        <div class="inputGroup">
            <input id="nomeAluno" class="inputUser" type="text" name="studentFirstName" required>
            <label class="labelInput" for="nomeAluno">Nome do Aluno</label>
        </div>
        <div class="inputGroup">
            <input id="sobrenomeAluno" class="inputUser" type="text" name="studentLastName" required>
            <label class="labelInput" for="sobrenomeAluno">Sobrenome do Aluno</label>
        </div>
        <div class="inputGroup">
            <input id="matriculaAluno" class="inputUser" type="text" name="studentRegister" required>
            <label class="labelInput" for="matriculaAluno">Matrícula do Aluno</label>
        </div>
        <div class="inputGroup">
            <input id="senhaAluno" class="inputUser" type="password" name="studentPassword" required>
            <label class="labelInput" for="senhaAluno">Senha do Aluno</label>
        </div>
        <div class="inputGroup">
            <input id="dataNascimentoAluno" class="inputUser" type="date" name="studentBirth" required>
            <label id="labelDataNascimentoAluno" class="labelInput" for="dataNascimentoAluno">Data de Nascimento do Aluno</label>
        </div>
        <input type="submit" name="submit" id="cadastrarBtn" value="CADASTRAR ALUNO">
    </form>
</main>
<script crossorigin="anonymous"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>