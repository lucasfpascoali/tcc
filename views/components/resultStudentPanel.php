<div class="resultPanel">
    <?php foreach ($students as $student) :?>
    <?php
        $dateFormatted = new DateTime($student->birth_date);
        $session = new \Source\Core\Session();

        if ($session->studentSelectMode)
    :?>
            <span class="resultRow">
                <p><a href="./cadastroEmprestimo.php?studentID=<?= $student->id ?>"><?= "{$student->first_name} {$student->last_name} - Matrícula: {$student->registration} 
                    - Data de Nascimento: {$dateFormatted->format('d/m/Y')}" ?></a></p>
                <a style="margin-bottom: 5px;" class="btn btn-success" href="./cadastroEmprestimo.php?studentID=<?= $student->id ?>" role="button">Selecionar</a>
            </span>
        <?php else :?>
            <span class="resultRow">
                <p><a href="./cadastroAluno.php?studentID=<?= $student->id ?>"><?= "{$student->first_name} {$student->last_name} - Matrícula: {$student->registration} 
                    - Data de Nascimento: {$dateFormatted->format('d/m/Y')}" ?></a></p>
                <a onclick="return confirm('Tem certeza que quer excluir este aluno?');" style="margin-bottom: 5px;" class="btn btn-danger" href="../Controllers/deleteStudentController.php?studentID=<?= $student->id ?>" role="button">Excluir</a>
            </span>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
