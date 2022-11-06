<div class="loanPanel">
    <?php /** @var \Source\Models\Loan $loan */
    foreach ($loans as $loan) :?>
        <div class="loanRow">
            <span class="textGroup">
                <p class="textInfo" style="margin: 0 0 10px 0;">Aluno: <?= "{$loan->getStudent()->first_name} {$loan->getStudent()->last_name}" ?><br>Livro:  <?= "{$loan->getBook()->title} ({$loan->getBook()->getBookCode()})" ?></p>
            </span>
            <?= $loan->renderLoanStatus() ?>
            <a style="width: 20%; text-align: center;" class="btn btn-success" href="./emprestimo?loanID=<?= $loan->id ?>" role="button" >Visualizar</a>
        </div>
    <?php endforeach; ?>
</div>
<div class="bottomLoanPanel">
    <h3><a href="./buscar/emprestimos.php">Ver todos os empréstimos</a></h3>
</div>
