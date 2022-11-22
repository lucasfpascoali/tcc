<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>SAB - Relatório</title>
    <link crossorigin="anonymous" href="../assets/css/bootstrap.min.css"
          integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" rel="stylesheet">
    <link href="../assets/css/relatorio.css" media="screen" rel="stylesheet" type="text/css"/>
    <link href="../assets/css/nav.css" media="screen" rel="stylesheet" type="text/css"/>
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
<?php
    require __DIR__ . "/../Controllers/login/verifyController.php";
    require_once  __DIR__ . "/../autoload.php";

//    $mode = filter_input(INPUT_GET, 'mode', FILTER_SANITIZE_SPECIAL_CHARS);
//    if (!$mode) {
//        $mode = 'loan';
//    }
//
//    $loan = [
//            'dropdown-title' => 'Empréstimos',
//            'active' => "",
//    ];
//
//    $student = [
//        'dropdown-title' => 'Alunos',
//        'active' => ""
//    ];
//
//    $book = [
//        'dropdown-title' => 'Livros',
//        'active' => ""
//    ];
//
//    $worker = [
//        'dropdown-title' => 'Funcionários',
//        'active' => ""
//    ];
//
//    switch ($mode) {
//        case 'loan':
//            $loan['active'] = ' active';
//            $template = $loan;
//            break;
//        case 'student':
//            $student['active'] = ' active';
//            $template = $student;
//            break;
//        case 'book':
//            $book['active'] = ' active';
//            $template = $book;
//            break;
//        case 'worker':
//            $worker['active'] = ' active';
//            $template = $worker;
//            break;
//    }

    $student = new \Source\Models\Student();
    $book = new \Source\Models\Book();
    $loan = new \Source\Models\Loan();
    $user = new \Source\Models\User();

    require __DIR__ . "./components/nav.php";
?>
<main>
    <header>
        <h2>Relatórios</h2>
<!--        <div style="width: 170.68px;" class="btn-group">-->
<!--            <button class="btn btn-success btn-lg dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">-->
<!--                --><?//= $template['dropdown-title'] ?>
<!--            </button>-->
<!--            <ul class="dropdown-menu">-->
<!--                <li><a class="dropdown-item--><?//= $loan['active'] ?><!--" href="./relatorio.php">Empréstimos</a></li>-->
<!--                <li><a class="dropdown-item--><?//= $student['active'] ?><!--" href="./relatorio.php?mode=student">Alunos</a></li>-->
<!--                <li><a class="dropdown-item--><?//= $book['active'] ?><!--" href="./relatorio.php?mode=book">Livros</a></li>-->
<!--                <li><a class="dropdown-item--><?//= $worker['active'] ?><!--" href="./relatorio.php?mode=worker">Funcionários</a></li>-->
<!--            </ul>-->
<!--        </div>-->
    </header>
    <article>
        <div class="reportGroup">
            <p>Total de alunos cadastrados: <?= $student->count() ?></p>
            <p>Total de livros cadastrados: <?= $book->count() ?></p>
            <p>Total de funcionários cadastrados: <?= $user->count() ?></p>
        </div>
        <div class="reportGroup">
            <p>Total de empréstimos cadastrados: <?= $loan->count() ?></p>
            <p>Total de empréstimos ativos: <?= $loan->countActive() ?></p>
            <p>Total de empréstimos finalizados: <?= ($loan->count() - $loan->countActive()) ?></p>
        </div>
        <div class="buttonGroup">
            <a style="margin-bottom: 5px;" class="btn btn-success" href="./buscar/alunos.php" role="button">Alunos</a>
            <a style="margin-bottom: 5px;" class="btn btn-success" href="./buscar/livros.php" role="button">Livros</a>
            <a style="margin-bottom: 5px;" class="btn btn-success" href="./buscar/funcionarios.php" role="button">Funcionários</a>
            <a style="margin-bottom: 5px;" class="btn btn-success" href="./buscar/emprestimos.php" role="button">Empréstimos</a>
        </div>
    </article>
</main>
<script crossorigin="anonymous"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
