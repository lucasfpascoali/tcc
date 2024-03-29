<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Funcionário</title>
    <link crossorigin="anonymous" href="../../assets/css/bootstrap.min.css"
          integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../../assets/css/cadastroFuncionario.css" media="screen"/>
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

$modalRedirect = null;

require __DIR__ . "/../components/nav.php";
?>
<main>
    <h2>Preencha os dados do Funcionário:</h2>
    <form autocomplete="off" action="../../Controllers/user/newController.php" method="post">
        <div class="inputGroup">
            <input id="workerFirstName" class="inputUser" type="text" name="workerFirstName" required>
            <label class="labelInput" for="workerFirstName">Nome do Funcionário</label>
        </div>
        <div class="inputGroup">
            <input id="workerLastName" class="inputUser" type="text" name="workerLastName" required>
            <label class="labelInput" for="workerLastName">Sobrenome do Funcionário</label>
        </div>
        <div class="inputGroup">
            <input id="workerCpf" class="inputUser" type="text" name="workerCpf" maxlength="11" required>
            <label class="labelInput" for="workerCpf">CPF do Funcionário</label>
        </div>
        <div class="inputGroup">
            <input id="workerPassword" class="inputUser" type="password" name="workerPassword" required>
            <label class="labelInput" for="workerPassword">Senha do Funcionário</label>
        </div>
        <input type="submit" name="submit" id="cadastrarBtn" value="CADASTRAR FUNCIONÁRIO">
    </form>
</main>
<script crossorigin="anonymous"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        src="../../assets/js/bootstrap.bundle.min.js"></script>
<?php
if ($message) {
    require __DIR__ . "/../components/feedBackModal.php";
}
?>
</body>
</html>