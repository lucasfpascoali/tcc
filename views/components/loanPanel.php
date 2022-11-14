<div class="loanPanel">
    <?php /** @var \Source\Models\Loan $loan */
    foreach ($loans as $loan) :?>
        <div class="loanRow">
            <span class="textGroup">
                <p class="textInfo" style="margin: 0 0 10px 0;">Aluno: <?= "{$loan->getStudent()->first_name} {$loan->getStudent()->last_name}" ?><br>Livro:  <?= "{$loan->getBook()->title} ({$loan->getBook()->getBookCode()})" ?></p>
            </span>
            <?= $loan->renderLoanStatus() ?>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal<?= $loan->id ?>">
                Visualizar
            </button>
        </div>
        <?php
            $book = $loan->getBook();
            $student = $loan->getStudent();

            $loanDate = (new DateTime($loan->loan_date))->format(CONF_DATE_BR);
            $loanReturnDate = (new DateTime($loan->expected_return_date))->format(CONF_DATE_BR);
        ?>
        <div class="modal fade" id="modal<?= $loan->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Empréstimo em andamento: <?= $loan->renderLoanStatus() ?></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><a href="editar/aluno.php?studentID=<?= $student->id ?>">Aluno: <?= "{$student->first_name} {$student->last_name} - Matrícula: {$student->registration}" ?></a></p>
                        <p><a href="editar/livro.php?bookID=<?= $book->id ?>">Livro: <?= "{$book->title} - Autor: {$book->author} ({$book->getBookCode()}) " ?></a></p>
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
                        <a style="width: 30%" class="btn btn-success" href="../Controllers/loan/finishController.php?loanID=<?= $loan->id ?>&redirect=index" role="button">Finalizar</a>
                        <a style="width: 30%; --bs-btn-color: #fff; --bs-btn-hover-color: #fff;" class="btn btn-info" href="../Controllers/loan/renewController.php?loanID=<?= $loan->id ?>&redirect=index" role="button">Renovar</a>
                        <a style="width: 30%" class="btn btn-danger" href="../Controllers/loan/deleteController.php?loanID=<?= $loan->id ?>&redirect=index" onclick="return confirm('Tem certeza que quer excluir esse empréstimo?');" role="button">Excluir</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

