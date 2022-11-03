<div class="resultPanel">
    <?php
    foreach ($loans as $loan) :?>
    <?php
        $book = (new \Source\Models\Book())->findById($loan->book_id);
        $student = (new \Source\Models\Student())->findById($loan->student_id);
        $loanDate = (new DateTime($loan->loan_date))->format(CONF_DATE_BR);
        if ($loan->return_date) {
            $returnDate = (new DateTime($loan->return_date))->format(CONF_DATE_BR);
            $status = "Empréstimo finalizado em: {$returnDate}";
        } else {
            $expectedDate = (new DateTime($loan->expected_return_date))->format(CONF_DATE_BR);
            $status = "- Empréstimo em andamento até: {$expectedDate} <span style='color: #FFC107'>( {$loan->getRemainingDays()} dia(s) restante(s) )</span>";
        }
    ?>
        <span class="resultRow">
            <span class="textGroup">
                <p><a href="./emprestimo.php?loanID=<?= $loan->id ?>"><?= "Aluno: {$student->first_name} {$student->last_name} 
                    - Livro: {$book->title} ({$book->getBookCode()})" ?></a></p>
                <p>Data do Empréstimo: <?= $loanDate ?> <?= $status ?></p>
            </span>
        <a style="margin-bottom: 5px; height: 38px" class="btn btn-success" href="../../../Controllers/user/deleteController.php?userID=<?= $loan->id ?>" role="button">Visualizar</a>
    </span>
    <?php endforeach; ?>
</div>
