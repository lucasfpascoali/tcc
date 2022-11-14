<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>SAB - Usuário</title>
    <link crossorigin="anonymous" href="../../assets/css/bootstrap.min.css"
          integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" rel="stylesheet">
    <link href="../../assets/css/cadastroFuncionario.css" media="screen" rel="stylesheet" type="text/css"/>
    <link href="../../assets/css/nav.css" media="screen" rel="stylesheet" type="text/css"/>
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php
        require __DIR__ . "/../../Controllers/login/verifyController.php";
        require_once __DIR__ . "/../../autoload.php";

        $session = new \Source\Core\Session();
        $message = $session->flash();
        $modalRedirect = null;

        $user = (new \Source\Models\User())->findById($session->login);

        require __DIR__ . "/../components/nav.php";
    ?>
    <main>
        <h2>Altere os dados que deseja atualizar:</h2>
        <form autocomplete="off" action="../../Controllers/user/editController.php" method="post">
            <div class="inputGroup">
                <input id="workerFirstName" class="inputUser" type="text" name="workerFirstName" value="<?= $user->first_name ?>" required>
                <label class="labelInput" for="workerFirstName">Nome</label>
            </div>
            <div class="inputGroup">
                <input id="workerLastName" class="inputUser" type="text" name="workerLastName" value="<?= $user->last_name ?>" required>
                <label class="labelInput" for="workerLastName">Sobrenome</label>
            </div>
            <div class="inputGroup">
                <input id="workerCpf" class="inputUser" type="text" name="workerCpf" maxlength="11" value="<?= $user->cpf ?>" required>
                <label class="labelInput" for="workerCpf">CPF</label>
            </div>
            <div class="inputGroup">
                <input id="workerPassword" class="inputUser" type="password" name="workerPassword">
                <label class="labelInput" for="workerPassword">Senha (<span style="color: #FF0000">deixe em branco caso não queira alterar</span>)</label>
            </div>
            <div class="inputGroup">
                <input id="workerPasswordVerify" class="inputUser" type="password" name="workerPasswordVerify">
                <label class="labelInput" for="workerPasswordVerify">Confirmar a Senha (<span style="color: #FF0000">deixe em branco caso não queira alterar</span>)</label>
            </div>
            <input type="submit" name="submit" id="cadastrarBtn" value="EDITAR DADOS">
        </form>
    </main>

<script crossorigin="anonymous"w
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        src="../../assets/js/bootstrap.bundle.min.js"></script>
    <?php
    if ($message) {
        require __DIR__ . "/../components/feedBackModal.php";
    }
    ?>
</body>
</html>