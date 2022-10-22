<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Livro</title>
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
          integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../assets/css/cadastroLivro.css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="../assets/css/nav.css" media="screen"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
<?php

use Source\Core\Session;

require __DIR__ . "/../Controllers/verifyLoginController.php";
require_once __DIR__ . "/../autoload.php";


$session = new Session();
$message = $session->flash();
$genre = new \Source\Models\Genre();
$genres = $genre->all();


require __DIR__ . "./components/nav.php";
?>

<main>
    <h2>Preencha os dados do Livro:</h2>
    <form action="../Controllers/bookController.php" method="post">
        <?php
        if ($message) {
            echo $message->render();
        }
        ?>
        <div class="formInputs">
            <section class="inputSection">
                <div class="inputGroup">
                    <input id="bookTitle" class="inputUser" type="text" name="bookTitle" required>
                    <label class="labelInput" for="bookTitle">Título do Livro</label>
                </div>
                <div class="inputGroup">
                    <input id="bookAuthor" class="inputUser" type="text" name="bookAuthor" required>
                    <label class="labelInput" for="bookAuthor">Autor do Livro</label>
                </div>
                <div class="inputGroup">
                    <input id="publishingCompany" class="inputUser" type="text" name="publishingCompany">
                    <label class="labelInput" for="publishingCompany">Editora</label>
                </div>
                <div class="inputRow">
                    <div class="inputSplit">
                        <input id="numberOfPages" class="inputUser" type="number" name="numberOfPages" min="1">
                        <label class="labelInput" for="numberOfPages">Número de Páginas</label>
                    </div>
                    <div class="inputSplit">
                        <input id="ISBN" class="inputUser" type="text" name="ISBN" maxlength="13">
                        <label class="labelInput" for="ISBN">ISBN</label>
                    </div>
                </div>
                <div id="inputSelect" class="inputGroup">
                    <p>Gênero Literário:</p>
                    <select name="genreID">
                        <?php
                        foreach ($genres as $genre):?>
                        <option value="<?= $genre->id ?>"><?= $genre->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </section>
            <section class="textareaSection">
                <div class="inputGroup">
                    <textarea id="synopsis" name="synopsis" rows="5" cols="40" maxlength="800"></textarea>
                    <label class="labelInput" for="synopsis">Sinopse:</label>
                </div>
                <div class="inputGroup">
                    <textarea id="note" name="note" rows="5" cols="40" maxlength="500"></textarea>
                    <label class="labelInput" for="note">Observação:</label>
                </div>
            </section>
        </div>
        <input type="submit" name="submit" id="cadastrarBtn" value="CADASTRAR LIVRO">
    </form>
</main>
<script crossorigin="anonymous"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>