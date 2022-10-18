<form class="newGenrePanel" method="post" action="../Controllers/genreController.php<?= ($genreID != null) ? "?genreID={$genreID}" : "" ?>">
    <?php
    if ($message) {
        echo $message->render();
    }
    ?>
    <div class="inputGroup">
        <input class="inputUser" id="genreName" type="text" name="genreName" value="<?= ($genre->name ?? "") ?>" required>
        <label class="labelInput" for="genreName">Nome do Gênero Literário</label>
    </div>
    <input class="btn btn-primary" style="--bs-btn-bg: #42EE5E; --bs-btn-hover-bg: #42EE5E; --bs-btn-border-color: #42EE5E; --bs-btn-hover-border-color: #42EE5E;" type="submit" name="addGenre" value="<?= ($genreID != null ? "Editar Gênero" : "Cadastrar Gênero") ?>">
</form>
