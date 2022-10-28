<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>SAB - Livros</title>
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
          integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" rel="stylesheet">
    <link href="../assets/css/search.css" media="screen" rel="stylesheet" type="text/css"/>
    <link href="../assets/css/nav.css" media="screen" rel="stylesheet" type="text/css"/>
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<?php
    require __DIR__ . "/../Controllers/verifyLoginController.php";
    require_once __DIR__ . "/../autoload.php";

    require __DIR__ . "./components/nav.php";

    $searchData = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
    $books = new \Source\Models\Book();

    if ($searchData) {
        $books = $books->search($searchData['searchMethod'], $searchData['searchValue'], $searchData['orderMethod']);
    } else {
        $books = $books->all();
    }
?>
<main>
    <form action="./livros.php" method="get">
        <div class="sidebar">
            <span class="searchOptions">
                <p>Opções de pesquisa:</p>
                <div class="inputGroup">
                    <input type="radio" id="title" value="title" name="searchMethod" checked>
                    <label for="title">Título</label>
                </div>
                <div class="inputGroup">
                    <input type="radio" id="author" value="author" name="searchMethod">
                    <label for="author">Autor</label>
                </div>
                <div class="inputGroup">
                    <input type="radio" id="bookCode" value="concat(book_code_letter, book_code_number, book_example_number)" name="searchMethod">
                    <label for="bookCode">Código de Livro</label>
                </div>
                <div class="inputGroup">
                    <input type="radio" id="isbn" value="isbn" name="searchMethod">
                    <label for="isbn">ISBN</label>
                </div>
                <div class="inputGroup">
                    <input type="radio" id="publishing_company" value="publishing_company" name="searchMethod">
                    <label for="publishing_company">Editora</label>
                </div>
            </span>
            <span class="searchOptions">
                <p>Ordenar por:</p>
                <select name="orderMethod" id="orderMethod">
                    <option value="title ASC" selected>Título Crescente</option>
                    <option value="title DESC">Título Decrescente</option>
                    <option value="book_code_letter, book_code_number, book_example_number ASC">Código do Livro Crescente</option>
                    <option value="book_code_letter, book_code_number, book_example_number DESC">Código do Livro Decrescente</option>
                </select>
            </span>
        </div>
        <div class="mainPanel">
            <div class="searchPanel">
                <input autocomplete="off" id="searchValue" type="search" name="searchValue" placeholder="Pesquisar por..." required>
                <button type="submit" style="border: 0; background-color: transparent; font-size: 24px;"><i class="fa fa-search"></i></button>
            </div>
            <?php
                if ($books) {
                    require __DIR__ . "./components/resultBookPanel.php";
                } else if ($searchData) {
                    echo "<div style='width: 100%; height: 100%; display: flex; justify-content: center; align-items: center'><h3>Nenhum livro encontrado!</h3></div>";
                } else {
                    echo "<div style='width: 100%; height: 100%; display: flex; justify-content: center; align-items: center'><h3>Não há nenhum livro cadastrado no sistema!</h3></div>";
                }
            ?>
        </div>
    </form>
</main>

<script crossorigin="anonymous"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
