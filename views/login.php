<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAB - Login</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/login.css" media="screen"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
<h2 id="logoText" style="color: #000; margin: 10px 0px -10px 0px;">E.E.B Apolônio Ireno Cardoso</h2>
<main id="loginBox">
    <h1>Entre na sua conta</h1>

    <?php

    use Source\Core\Session;

    require __DIR__ . "/../autoload.php";

    $session = new Session();
    $message = $session->flash();
    if ($message) {
        echo $message->render();
    }
    ?>

    <form action="../Controllers/loginController.php" method="post">
        <div class="inputGroup">
            <input class="inputUser" id="userCpf" type="text" name="userCpf" maxlength="11" required>
            <label class="labelInput" for="userCpf">CPF</label>
        </div>
        <div class="inputGroup">
            <input class="inputUser" id="userPassword" type="password" name="userPassword" maxlength="40" required>
            <label class="labelInput" for="userPassword">Senha</label>
        </div>
        <span id="bottomBtn">
                <input type="submit" name="login" value="ENTRAR">
                <p><a id="resetPassword" href="">Esqueceu a senha?</a></p>
        </span>
    </form>
</main>
</body>
</html>