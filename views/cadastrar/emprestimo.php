<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Funcionário</title>
    <link crossorigin="anonymous" href="../../assets/css/bootstrap.min.css"
          integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../../assets/css/cadastroEmprestimo.css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="../../assets/css/nav.css" media="screen"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
<?php
    require __DIR__ . "/../../Controllers/login/verifyController.php";
    require_once __DIR__ . "/../../autoload.php";

    require __DIR__ . "/../components/nav.php";

    // Session Preferences Reset
    $session = new \Source\Core\Session();
    $session->unset('bookSelectMode');
    $session->unset('studentSelectMode');

    $message = $session->flash();
    $modalRedirect = '../buscar/emprestimos.php?loanID=';

    $today = new DateTime();
    $expectedDate = (new DateTime())->modify('+15 days');

    $bookID = filter_input(INPUT_GET, 'bookID', FILTER_VALIDATE_INT);
    if ($bookID) {
        $session->set('bookID', $bookID);
    }
    $studentID = filter_input(INPUT_GET, 'studentID', FILTER_VALIDATE_INT);
    if ($studentID) {
        $session->set('studentID', $studentID);

    }

    if ($session->bookID) {
        $book = (new \Source\Models\Book())->findById($session->bookID);
    }

    if ($session->studentID) {
        $student = (new \Source\Models\Student())->findById($session->studentID);
    }
?>
<form autocomplete="off" action="../../Controllers/loan/newController.php" method="post">
    <section class="searchSection">
        <?php if ($session->studentID) :?>
            <h4>Aluno selecionado:</h4>
            <p><?= "Nome: {$student->first_name} {$student->last_name}" ?></p>
            <p><?= "Matrícula: {$student->registration}" ?></p>
            <div class="inputGroup">
                <input id="studentPassword" class="inputUser" type="password" name="studentPassword" required>
                <label id="labelStudentPassword" class="labelInput" for="studentPassword">Senha do Aluno</label>
            </div>
            <a style="width: 40%; border: 1px solid #42EE5E; border-radius: 20px; text-align: center; color: #42EE5E" href="../buscar/alunos.php?selectMode=1">Trocar Aluno</a>
        <?php else :?>
            <h4>Clique aqui para selecionar um aluno:</h4>
            <div class="myBtn register-btn">
                <a class="full" href="../buscar/alunos.php?selectMode=1">
                    <img class="btnIcon" src="../../assets/img/btnStudent.png"/>
                </a>
            </div>
        <?php endif; ?>
    </section>
    <div class="verticalLine"></div>
    <section class="searchSection">
        <?php if ($session->bookID) :?>
            <h4>Livro selecionado:</h4>
            <p>Título: <?= $book->title ?></p>
            <p>Autor: <?= $book->author ?></p>
            <p>Editora: <?= $book->publishing_company ?></p>
            <p>Código do Livro: <?= $book->getBookCode() ?></p>
            <a style="width: 40%; border: 1px solid #42EE5E; border-radius: 20px; text-align: center; color: #42EE5E" href="../buscar/livros.php?selectMode=1">Trocar Livro</a>
        <?php else :?>
            <h4>Clique aqui para selecionar um livro:</h4>
            <div class="myBtn register-btn">
                <a class="full" href="../buscar/livros.php?selectMode=1">
                    <img style="width: 90%;" class="btnIcon" src="../../assets/img/btnBook.png"/>
                </a>
            </div>
        <?php endif; ?>
    </section>
    <div class="verticalLine"></div>
    <section class="loanSection">
        <h5>Preencha os Dados do Empréstimo:</h5>
        <div class="inputGroup">
            <input id="loanDate" class="inputUser" type="date" name="loanDate" value="<?= $today->format('Y-m-d') ?>" required readonly>
            <label id="labelLoanDate" class="labelInput" for="loanDate">Data do Empréstimo</label>
        </div>
        <div class="inputGroup">
            <input id="expectedReturnDate" class="inputUser" type="date" name="expectedReturnDate" value="<?= $expectedDate->format('Y-m-d') ?>" required readonly>
            <label id="labelExpectedReturnDate" class="labelInput" for="expectedReturnDate">Data Prevista de Retorno do Empréstimo (+15 dias)</label>
        </div>
        <div class="inputGroup">
            <textarea id="obs" name="obs" rows="5" cols="40" maxlength="255"></textarea>
            <label class="labelInput" for="obs">Observação:</label>
        </div>
        <?php if ($session->bookID && $session->studentID) :?>
            <input type="submit" name="submit" id="cadastrarBtn" value="CADASTRAR EMPRÉSTIMO">
        <?php else :?>
            <p style="color: #FF0000">Selecione um aluno e um livro primeiro!</p>
            <input type="submit" name="submit" id="cadastrarBtn" value="CADASTRAR EMPRÉSTIMO" disabled>
        <?php endif; ?>
    </section>
</form>

<script crossorigin="anonymous"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        src="../../assets/js/bootstrap.bundle.min.js"></script>
<?php
    if ($message) {
        require __DIR__ . "/../components/feedBackModal.php";
    }
?>
</body>
</html>
