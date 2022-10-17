<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>SAB - Gêneros Literários</title>
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
          integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" rel="stylesheet">
    <link href="../assets/css/generos.css" media="screen" rel="stylesheet" type="text/css"/>
    <link href="../assets/css/nav.css" media="screen" rel="stylesheet" type="text/css"/>
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
<?php
    require __DIR__ . "/../Controllers/verifyLoginController.php";
    require_once __DIR__ . "/../autoload.php";
    require __DIR__ . "./components/nav.php";
?>
<main>
    <?php
        $genreId = filter_input(INPUT_GET, 'genreId', FILTER_VALIDATE_INT);

        if (!$genreId) {
            require __DIR__ . "./components/newGenrePanel.php";
        }
    ?>
    <div id="vertical-line"></div>
    <section class="genreItens">
        <span class="genreRow">
            <p>Gênero</p>
            <span class="buttonGroup">
                <a class="btn btn-info" style="--bs-btn-color: #fff; --bs-btn-hover-color: #fff;" href="#" role="button">Editar</a>
                <a class="btn btn-danger" href="#" role="button">Excluir</a>
            </span>
        </span>
        <span class="genreRow">
            <p>Gênero</p>
            <span class="buttonGroup">
                <a class="btn btn-info" style="--bs-btn-color: #fff; --bs-btn-hover-color: #fff;" href="#" role="button">Editar</a>
                <a class="btn btn-danger" href="#" role="button">Excluir</a>
            </span>
        </span>
        <span class="genreRow">
            <p>Gênero</p>
            <span class="buttonGroup">
                <a class="btn btn-info" style="--bs-btn-color: #fff; --bs-btn-hover-color: #fff;" href="#" role="button">Editar</a>
                <a class="btn btn-danger" href="#" role="button">Excluir</a>
            </span>
        </span>
        <span class="genreRow">
            <p>Gênero</p>
            <span class="buttonGroup">
                <a class="btn btn-info" style="--bs-btn-color: #fff; --bs-btn-hover-color: #fff;" href="#" role="button">Editar</a>
                <a class="btn btn-danger" href="#" role="button">Excluir</a>
            </span>
        </span>
        <span class="genreRow">
            <p>Gênero</p>
            <span class="buttonGroup">
                <a class="btn btn-info" style="--bs-btn-color: #fff; --bs-btn-hover-color: #fff;" href="#" role="button">Editar</a>
                <a class="btn btn-danger" href="#" role="button">Excluir</a>
            </span>
        </span>
    </section>
</main>

<script crossorigin="anonymous"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</body>