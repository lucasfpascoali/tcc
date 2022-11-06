<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>SAB - Aluno</title>
    <link crossorigin="anonymous" href="../../assets/css/bootstrap.min.css"
          integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" rel="stylesheet">
    <link href="../../assets/css/aluno.css" media="screen" rel="stylesheet" type="text/css"/>
    <link href="../../assets/css/nav.css" media="screen" rel="stylesheet" type="text/css"/>
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php
        require __DIR__ . "/../../Controllers/login/verifyController.php";
        require_once __DIR__ . "/../../autoload.php";

        $studentID = filter_input(INPUT_GET, 'studentID', FILTER_VALIDATE_INT);
        if (!$studentID) {
            redirect('views/buscar/alunos.php');
        }

        $student = (new \Source\Models\Student())->findById($studentID);
        if (!$student) {
            redirect('views/buscar/alunos.php');
        }

        $session = new \Source\Core\Session();
        $session->set('editStudentID', $studentID);
        $message = $session->flash();

        $loans = $student->getActiveLoans();

        require __DIR__ . "/../components/nav.php";
    ?>
<main>
    <form action="../../Controllers/student/editController.php" method="post">
        <h2><?= ($message ?? "Atualizar Aluno:") ?></h2>
        <div class="inputRow">
            <div class="inputGroup">
                <input id="nomeAluno" class="inputUser" type="text" name="studentFirstName" value="<?= $student->first_name ?>" required>
                <label class="labelInput" for="nomeAluno">Nome do Aluno</label>
            </div>
            <div class="inputGroup">
                <input id="sobrenomeAluno" class="inputUser" type="text" name="studentLastName" value="<?= $student->last_name ?>" required>
                <label class="labelInput" for="sobrenomeAluno">Sobrenome do Aluno</label>
            </div>
        </div>
        <div class="inputRow">
            <div class="inputGroup">
                <input id="matriculaAluno" class="inputUser" type="text" name="studentRegister" value="<?= $student->registration ?>" required>
                <label class="labelInput" for="matriculaAluno">Matrícula do Aluno</label>
            </div>
            <div class="inputGroup">
                <input id="senhaAluno" class="inputUser" type="password" name="studentPassword">
                <label class="labelInput" for="senhaAluno">Senha do Aluno</label>
            </div>
        </div>
        <div class="inputGroup">
            <input id="dataNascimentoAluno" class="inputUser" type="date" name="studentBirth" value="<?= $student->birth_date ?>" required>
            <label id="labelDataNascimentoAluno" class="labelInput" for="dataNascimentoAluno">Data de Nascimento do Aluno</label>
        </div>
        <input type="submit" name="submit" id="editarBtn" value="EDITAR ALUNO">
        <?php if ($loans) :?>
            <a style="width: 80%" class="btn btn-danger" onclick="return confirm('Não é possível excluir um aluno com empréstimos ativos!');" href="#" role="button">Excluir</a>
        <?php else :?>
            <a style="width: 80%" class="btn btn-danger" onclick="return confirm('Tem certeza que quer excluir este aluno?');" href="../../Controllers/student/deleteController.php?studentID=<?= $studentID ?>" role="button">Excluir</a>
        <?php endif; ?>
    </form>
    <div class="side">
        <h2 style="width: 100%; text-align: center">Empréstimos em Andamento:</h2>
        <div class="studentLoanPanel">
            <?php if ($loans) :?>
                <?php
                /** @var \Source\Models\Loan $loan */
                foreach ($loans as $loan) :?>
                    <?php $book = (new \Source\Models\Book())->findById($loan->book_id); ?>
                    <span class="loanRow">
                        <a href="../editar/emprestimo.php?loanID=<?= $loan->id ?>">
                            <p>Livro: <?= $book->title ?> (<?= $book->getBookCode(); ?>)</p>
                            <p><?= $loan->renderLoanStatus(); ?></p>
                        </a>
                        <a style="margin-bottom: 5px; height: 38px" class="btn btn-success" href="../editar/emprestimo.php?loanID=<?= $loan->id ?>" role="button">Visualizar</a>
                    </span>
                <?php endforeach; ?>
            <?php else :?>
                <h4>Nenhum empréstimo ativo</h4>
            <?php endif; ?>
        </div>
    </div>
</main>

<script crossorigin="anonymous"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        src="../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
