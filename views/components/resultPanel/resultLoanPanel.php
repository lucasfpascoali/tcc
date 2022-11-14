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
            $expectedReturnDate = (new DateTime($loan->expected_return_date))->format(CONF_DATE_BR);
            $status = "Empréstimo vence em: {$expectedReturnDate} ({$loan->renderLoanStatus()})";
        }
    ?>
        <span class="resultRow">
            <span class="textGroup">
                <p><a href="./emprestimos.php?loanID=<?= $loan->id ?>"><?= "Aluno: {$student->first_name} {$student->last_name} 
                    - Livro: {$book->title} ({$book->getBookCode()})" ?></a></p>
                <p>Data do Empréstimo: <?= $loanDate ?> - <?= $status ?></p>
            </span>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal<?= $loan->id ?>">
                    Visualizar
            </button>
        </span>
        <?php
        $book = $loan->getBook();
        $student = $loan->getStudent();

        $loanDate = (new DateTime($loan->loan_date))->format(CONF_DATE_BR);
        $loanReturnDate = (new DateTime($loan->expected_return_date))->format(CONF_DATE_BR);
        ?>
        <?php if ($loan->return_date) :?>
            <div class="modal fade" id="modal<?= $loan->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Empréstimo Finalizado</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><a href="../editar/aluno.php?studentID=<?= $student->id ?>">Aluno: <?= "{$student->first_name} {$student->last_name} - Matrícula: {$student->registration}" ?></a></p>
                            <p><a href="../editar/livro.php?bookID=<?= $book->id ?>">Livro: <?= "{$book->title} - Autor: {$book->author} ({$book->getBookCode()}) " ?></a></p>
                            <p>Data do Empréstimo: <?= $loanDate ?> </p>
                            <p>Empréstimo finalizado em: <?= $returnDate ?></p>
                            <?php if ($loan->obs) :?>
                                <div class="inputGroupText">
                                    <textarea id="note" name="note" rows="5" cols="40" maxlength="400" readonly><?= $loan->obs ?></textarea>
                                    <label class="labelInput" for="note">Observação:</label>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div style="width: 100%; display: flex; justify-content: center;" class="modal-footer">
                            <button type="button" class="btn btn-success" data-bs-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php else :?>
            <div class="modal fade" id="modal<?= $loan->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Empréstimo em andamento: <?= $loan->renderLoanStatus() ?></h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><a href="../editar/aluno.php?studentID=<?= $student->id ?>">Aluno: <?= "{$student->first_name} {$student->last_name} - Matrícula: {$student->registration}" ?></a></p>
                            <p><a href="../editar/livro.php?bookID=<?= $book->id ?>">Livro: <?= "{$book->title} - Autor: {$book->author} ({$book->getBookCode()}) " ?></a></p>
                            <p>Data do Empréstimo: <?= $loanDate ?> </p>
                            <p>Empréstimo vence em: <?= $loanReturnDate ?></p>
                            <?php if ($loan->obs) :?>
                                <div class="inputGroupText">
                                    <textarea id="note" name="note" rows="5" cols="40" maxlength="400" readonly><?= $loan->obs ?></textarea>
                                    <label class="labelInput" for="note">Observação:</label>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div style="width: 100%; display: flex; justify-content: center;" class="modal-footer">
                            <a style="width: 30%" class="btn btn-success" href="../../Controllers/loan/finishController.php?loanID=<?= $loan->id ?>&redirect=buscar" role="button">Finalizar</a>
                            <a style="width: 30%; --bs-btn-color: #fff; --bs-btn-hover-color: #fff;" class="btn btn-info" href="../../Controllers/loan/renewController.php?loanID=<?= $loan->id ?>&redirect=buscar" role="button">Renovar</a>
                            <a style="width: 30%" class="btn btn-danger" href="../../Controllers/loan/deleteController.php?loanID=<?= $loan->id ?>&redirect=buscar" onclick="return confirm('Tem certeza que quer excluir esse empréstimo?');" role="button">Excluir</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
