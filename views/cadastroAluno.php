<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Aluno</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/styleCadastroAluno.css" media="screen" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php

        require __DIR__ . "/../Controllers/verifyLoginController.php";
        require __DIR__ . "/../autoload.php";

        $session = new \Source\Core\Session();
        $message = $session->flash();
        if ($message) {
            echo $message->render();
        }
    ?>
    <h2 id="logoText" style="color: #fff;">E.E.B Apolônio Ireno Cardoso</h2>
    <main>
        <h1>Preencha os dados do Aluno:</h1>
        <form action="../Controllers/studentController.php" method="post">
            <span id="campos-group">
                <input type="text" name="studentFirstName" id="nomeAluno" placeholder="Nome do Aluno" required>
                <input type="text" name="studentLastName" id="sobrenomeAluno" placeholder="Sobrenome do Aluno" required>
                <input type="text" name="studentRegister" id="matriculaAluno" placeholder="Matrícula do Aluno" required>
                <input type="password" name="studentPassword" id="senhaAluno" placeholder="Senha do Aluno" required>
                <input type="date" name="studentBirth" id="dataNascimentoAluno" placeholder="Data de Nascimento do Aluno" required>
            </span>
            <input type="submit" name="submit" id="cadastrarBtn" value="REALIZAR CADASTRO">
        </form>
    </main>
</body>
</html>