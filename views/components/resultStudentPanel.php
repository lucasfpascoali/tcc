<div class="resultPanel">
    <?php foreach ($students as $student) :?>
    <?php
        $dateFormatted = new DateTime($student->birth_date);
    ?>
        <span class="resultRow">
            <p><a href="./cadastroAluno.php?book_id=<?= $student->id ?>"><?= "{$student->first_name} {$student->last_name} - Matrícula: {$student->registration} 
                - Data de Nascimento: {$dateFormatted->format('d/m/Y')}" ?></a></p>
            <a onclick="return confirm('Tem certeza que quer excluir este aluno?');" style="margin-bottom: 5px;" class="btn btn-danger" href="../Controllers/deleteStudentController.php?studentID=<?= $student->id ?>" role="button">Excluir</a>
        </span>
    <?php endforeach; ?>
</div>
