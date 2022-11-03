<div class="resultPanel">
    <?php
    $session = new \Source\Core\Session();

    foreach ($books as $book) :?>
        <span class="resultRow">
            <?php if ($session->bookSelectMode) :?>
                <?php if ($book->status == 1) :?>
                    <p><a href="../cadastrar/emprestimo.php?bookID=<?= $book->id ?>"><?= "{$book->title} - {$book->author} 
                    ({$book->getBookCode()})" ?></a></p>
                    <a style="margin-bottom: 5px;" class="btn btn-success" href="../cadastrar/emprestimo.php?bookID=<?= $book->id ?>"
                       role="button">Selecionar</a>
                <?php else :?>
                    <p><a href="#"><?= "{$book->title} - {$book->author} ({$book->getBookCode()})" ?></a></p>
                    <a style="margin-bottom: 5px;" class="btn btn-warning" href="#" role="button" >Livro em Empréstimo</a>
                <?php endif; ?>
            <?php else :?>
                <p><a href="./cadastroLivro.php?bookID=<?= $book->id ?>"><?= "{$book->title} - {$book->author} ({$book->getBookCode()}) - Situação: " ?>
                        <?= ($book->status == 1) ? "Disponível"  : "Em Empréstimo" ?></a></p>
                <?php if ($book->status == 1) :?>
                    <a onclick="return confirm('Tem certeza que quer excluir este livro?');" style="margin-bottom: 5px;" class="btn btn-danger"
                       href="../../Controllers/book/deleteController.php?bookID=<?= $book->id ?>" role="button">Excluir</a>
                <?php else :?>
                    <a onclick="return confirm('Finalize o empréstimo do livro para poder excluí-lo!');" style="margin-bottom: 5px;" class="btn btn-warning"
                       href="#" role="button">Livro em Empréstimo</a>
                <?php endif; ?>
            <?php endif; ?>
        </span>
    <?php endforeach; ?>
</div>