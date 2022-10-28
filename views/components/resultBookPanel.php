<div class="resultPanel">
    <?php
    $session = new \Source\Core\Session();

    foreach ($books as $book) :?>
        <span class="resultRow">
            <?php if ($session->bookSelectMode) :?>
                <p><a href="./cadastroEmprestimo.php?bookID=<?= $book->id ?>"><?= "{$book->title} - {$book->author} 
                    ({$book->getBookCode()})" ?></a></p>
                <?php if ($book->status == 1) :?>
                    <a style="margin-bottom: 5px;" class="btn btn-success" href="./cadastroEmprestimo.php?bookID=<?= $book->id ?>"
                       role="button">Selecionar</a>
                <?php else :?>
                    <a style="margin-bottom: 5px;" class="btn btn-warning" href="#" role="button" >Livro em Empréstimo</a>
                <?php endif; ?>
            <?php else :?>
                <p><a href="./cadastroLivro.php?bookID=<?= $book->id ?>"><?= "{$book->title} - {$book->author} ({$book->getBookCode()}) - Situação: " ?>
                        <?= ($book->status) ? "Disponível"  : "Em Empréstimo" ?></a></p>
                <a onclick="return confirm('Tem certeza que quer excluir este livro?');" style="margin-bottom: 5px;" class="btn btn-danger"
                   href="../Controllers/deleteBookController.php?bookID=<?= $book->id ?>" role="button">Excluir</a>
            <?php endif; ?>
        </span>
    <?php endforeach; ?>
</div>