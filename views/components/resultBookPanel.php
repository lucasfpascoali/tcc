<div class="resultPanel">
    <?php
    foreach ($books as $book) :?>
        <span class="resultRow">
        <p><a href="./cadastroLivro.php?book_id=<?= $book->id ?>"><?= "{$book->title} - {$book->author} ({$book->getBookCode()})" ?></a></p>
        <a style="margin-bottom: 5px;" class="btn btn-danger" href="../Controllers/deleteBookController?book_id=<?= $book->id ?>" role="button">Excluir</a>
    </span>
    <?php endforeach; ?>
</div>