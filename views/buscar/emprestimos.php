<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>SAB - Empréstimos</title>
    <link crossorigin="anonymous" href="../../assets/css/bootstrap.min.css"
          integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" rel="stylesheet">
    <link href="../../assets/css/search.css" media="screen" rel="stylesheet" type="text/css"/>
    <link href="../../assets/css/nav.css" media="screen" rel="stylesheet" type="text/css"/>
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<?php
require __DIR__ . "/../../Controllers/login/verifyController.php";
require_once __DIR__ . "/../../autoload.php";

require __DIR__ . "/../components/nav.php";

$loanID = filter_input(INPUT_GET, 'loanID', FILTER_VALIDATE_INT);
$searchData = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
$loans = new \Source\Models\Loan();

if ($loanID) {
    $loans = [$loans->findById($loanID)];
}else if ($searchData) {
    $loans = $loans->search($searchData['searchMethod'], $searchData['searchValue'], $searchData['orderMethod']);
} else {
    $loans = $loans->all();
}
?>
<main>
    <form autocomplete="off" action="emprestimos.php" method="get">
        <div class="sidebar">
            <span class="searchOptions">
                <p>Opções de pesquisa:</p>
                <div class="inputGroup">
                    <input type="radio" id="studentName" value="1" name="searchMethod" checked>
                    <label for="studentName">Nome do Aluno</label>
                </div>
                <div class="inputGroup">
                    <input type="radio" id="studentRegistration" value="2" name="searchMethod">
                    <label for="studentRegistration">Matrícula do Aluno</label>
                </div>
                <div class="inputGroup">
                    <input type="radio" id="bookTitle" value="3" name="searchMethod">
                    <label for="bookTitle">Título do Livro</label>
                </div>
                <div class="inputGroup">
                    <input type="radio" id="bookCode" value="4" name="searchMethod">
                    <label for="bookCode">Código do Livro</label>
                </div>
            </span>
            <span class="searchOptions">
                <p>Ordenar por:</p>
                <select name="orderMethod" id="orderMethod">
                    <option value="first_name ASC, last_name ASC" selected>Nome Aluno Crescente</option>
                    <option value="first_name DESC, last_name DESC">Nome Aluno Decrescente</option>
                    <option value="title ASC">Título Livro Crescente</option>
                    <option value="title DESC">Título Livro Decrescente</option>
                    <option value="book_code_letter ASC, book_code_number ASC, book_example_number ASC">Código Livro Crescente</option>
                    <option value="book_code_letter DESC, book_code_number DESC, book_example_number DESC">Código Livro Decrescente</option>
                    <option value="loan_date ASC">Data de Empréstimo Crescente</option>
                    <option value="loan_date DESC">Data de Empréstimo Decrescente</option>
                    <option value="expected_return_date ASC">Data Prevista de Retorno Crescente</option>
                    <option value="expected_return_date DESC">Data Prevista de Retorno Decrescente</option>
                </select>
            </span>
        </div>
        <div class="mainPanel">
            <div class="searchPanel">
                <input id="searchValue" type="search" name="searchValue" placeholder="Pesquisar por..." required>
                <button type="submit" style="border: 0; background-color: transparent; font-size: 24px;"><i class="fa fa-search"></i></button>
            </div>
            <?php
            if ($loans) {
                require __DIR__ . "/../components/resultPanel/resultLoanPanel.php";
            } else if ($searchData) {
                echo "<div style='width: 100%; height: 100%; display: flex; justify-content: center; align-items: center'><h3>Nenhum empréstimo encontrado!</h3></div>";
            } else {
                echo "<div style='width: 100%; height: 100%; display: flex; justify-content: center; align-items: center'><h3>Não há nenhum empréstimo cadastrado no sistema!</h3></div>";
            }
            ?>
        </div>
    </form>
</main>
<script crossorigin="anonymous"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        src="../../assets/js/bootstrap.bundle.min.js"></script>
<?php if ($loanID && $loans) :?>
    <script>
        const myModal = new bootstrap.Modal(document.getElementById('modal<?= $loanID ?>'));
        myModal.show();
    </script>
<?php endif; ?>
</body>
</html>