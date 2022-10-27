<section class="genreItens">
    <?php
    foreach ($genres as $genre) :?>
        <span class="genreRow">
            <p><?= $genre->name ?></p>
            <span class="buttonGroup">
                <a class="btn btn-info" style="--bs-btn-color: #fff; --bs-btn-hover-color: #fff;" href="./generos.php?genreID=<?= $genre->id?>" role="button">Editar</a>
                <a class="btn btn-danger" onclick="return confirm('Todos os livros que possuem esse gênero ficarão sem gênero!');" href="../Controllers/deleteGenreController.php?genreID=<?= $genre->id?>" role="button">Excluir</a>
            </span>
        </span>
    <?php endforeach; ?>
</section>
