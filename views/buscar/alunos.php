<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>SAB - Alunos</title>
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
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

    $students = new \Source\Models\Student();
    $session = new \Source\Core\Session();

    $selectMode = filter_input(INPUT_GET, 'selectMode', FILTER_VALIDATE_INT);
    if ($selectMode) {
        $session->set('studentSelectMode', true);
    }

    $searchMethod = filter_input(INPUT_GET, 'searchMethod', FILTER_SANITIZE_SPECIAL_CHARS);
    $searchValue = filter_input(INPUT_GET, 'searchValue', FILTER_SANITIZE_SPECIAL_CHARS);
    $orderMethod = filter_input(INPUT_GET, 'orderMethod', FILTER_SANITIZE_SPECIAL_CHARS);


    if ($searchMethod && $searchValue && $orderMethod) {
        $students = $students->search($searchMethod, $searchValue, $orderMethod);
    } else {
        $students = $students->all();
    }
?>
<main>
    <form action="alunos.php" method="get">
        <div class="sidebar">
            <span class="searchOptions">
                <p>Opções de pesquisa:</p>
                <div class="inputGroup">
                    <input type="radio" id="name" value="name" name="searchMethod" checked>
                    <label for="name">Nome</label>
                </div>
                <div class="inputGroup">
                    <input type="radio" id="registration" value="registration" name="searchMethod">
                    <label for="registration">Matrícula</label>
                </div>
            </span>
            <span class="searchOptions">
                <p>Ordenar por:</p>
                <select name="orderMethod" id="orderMethod">
                    <option value="first_name ASC, last_name ASC" selected>Nome Crescente</option>
                    <option value="first_name DESC, last_name DESC">Nome Decrescente</option>
                    <option value="registration ASC">Matrícula Crescente</option>
                    <option value="registration DESC">Matrícula Decrescente</option>
                </select>
            </span>
        </div>
        <div class="mainPanel">
            <div class="searchPanel">
                <input id="searchValue" type="search" name="searchValue" placeholder="Pesquisar por..." required>
                <button type="submit" style="border: 0; background-color: transparent; font-size: 24px;"><i class="fa fa-search"></i></button>
            </div>
            <?php
            if ($students) {
                require __DIR__ . "/../components/resultPanel/resultStudentPanel.php";
            } else if ($searchMethod || $searchValue || $orderMethod) {
                echo "<div style='width: 100%; height: 100%; display: flex; justify-content: center; align-items: center'><h3>Nenhum aluno encontrado!</h3></div>";
            } else {
                echo "<div style='width: 100%; height: 100%; display: flex; justify-content: center; align-items: center'><h3>Não há nenhum aluno cadastrado no sistema!</h3></div>";
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

