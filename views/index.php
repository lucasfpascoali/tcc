<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/styleIndex.css" media="screen"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
<?php
require __DIR__ . "/../Controllers/verifyLoginController.php";
?>
<h2 id="logoText" style="color: #fff;">E.E.B Apolônio Ireno Cardoso</h2>
<main>
    <span id="principaisBtn">
        <a class="btn" id="novoEmprestimoBtn" href="">
            <img src="../assets/img/simbolo-de-mais-preto64px.png" alt="símbolo de mais">
            <h4>Novo Empréstimo</h4>
        </a>
        <span id="cadastrosBtn">
            <a class="btn" id="cadastroLivroBtn" href="#"><img src="../assets/img/livro-64px.png"
                alt="imagem de um livro">Cadastrar Livro</a>
            <a class="btn" id="cadastroAlunoBtn" href="./cadastroAluno.php"><img
                src="../assets/img/universidade64px.png" alt="imagem de um aluno">Cadastrar Aluno</a>
        </span>
    </span>
    <span class="btn" id="mostraEmprestimosBtn">
        <h5>Empréstimos em Andamento</h5>
    </span>
</main>
</body>
</html>