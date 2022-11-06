<div class="resultPanel">
    <?php /** @var \Source\Models\Student $student */
    foreach ($students as $student) :?>
    <?php
        $dateFormatted = new DateTime($student->birth_date);
        $session = new \Source\Core\Session();

        if ($session->studentSelectMode)
    :?>
            <span class="resultRow">
                <p><a href="../cadastrar/emprestimo.php?studentID=<?= $student->id ?>"><?= "{$student->first_name} {$student->last_name} - Matrícula: {$student->registration} 
                    - Data de Nascimento: {$dateFormatted->format('d/m/Y')}" ?></a></p>
                <a style="margin-bottom: 5px;" class="btn btn-success" href="../cadastrar/emprestimo.php?studentID=<?= $student->id ?>" role="button">Selecionar</a>
            </span>
        <?php else :?>
            <span class="resultRow">
                <p><a href="../editar/aluno.php?studentID=<?= $student->id ?>"><?= "{$student->first_name} {$student->last_name} - Matrícula: {$student->registration} 
                        - Data de Nascimento: {$dateFormatted->format('d/m/Y')}" ?></a></p>
                <?php if ($student->getActiveLoans()) :?>
                    <a onclick="return confirm('Não é possível excluir um aluno com empréstimos ativos!');" style="margin-bottom: 5px;" class="btn btn-warning"
                       href="#" role="button">Aluno com Empréstimos Pendentes</a>
                <?php else :?>
                    <a onclick="return confirm('Tem certeza que quer excluir este aluno?');" style="margin-bottom: 5px;" class="btn btn-danger" href="../../Controllers/student/deleteController.php?studentID=<?= $student->id ?>" role="button">Excluir</a>
                <?php endif; ?>
                </span>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
