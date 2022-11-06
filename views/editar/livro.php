<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>SAB - Aluno</title>
    <link crossorigin="anonymous" href="../../assets/css/bootstrap.min.css"
          integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" rel="stylesheet">
    <link href="../../assets/css/livro.css" media="screen" rel="stylesheet" type="text/css"/>
    <link href="../../assets/css/nav.css" media="screen" rel="stylesheet" type="text/css"/>
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php
        require __DIR__ . "/../../Controllers/login/verifyController.php";
        require_once __DIR__ . "/../../autoload.php";

        $bookID = filter_input(INPUT_GET, 'bookID', FILTER_VALIDATE_INT);
        if (!$bookID) {
            redirect('views/buscar/livros.php');
        }

        $book = (new \Source\Models\Book())->findById($bookID);
        if (!$book) {
            redirect('views/buscar/livros.php');
        }

        $loan = (new \Source\Models\Loan())->findByBookId($book->id);

        $session = new \Source\Core\Session();
        $session->set('editBookID', $bookID);
        $message = $session->flash();

        $genres = (new \Source\Models\Genre())->all();

        require __DIR__ . "/../components/nav.php";
    ?>
    <main>
        <form action="../../Controllers/book/editController.php" method="post">
            <h2><?= ($message ?? "Atualizar Livro:") ?></h2>
            <div class="inputPanel">
                <div class="inputRow">
                    <div class="inputGroup">
                        <input id="bookTitle" class="inputUser" type="text" name="bookTitle" value="<?= $book->title ?>" required>
                        <label class="labelInput" for="bookTitle">Título do Livro</label>
                    </div>
                    <div class="inputGroup">
                        <input id="bookAuthor" class="inputUser inputReadOnly" type="text" name="bookAuthor" value="<?= $book->author ?>" required>
                        <label class="labelInput" for="bookAuthor">Autor do Livro</label>
                    </div>
                    <div class="inputGroup">
                        <input id="publishingCompany" class="inputUser" type="text" name="publishingCompany" value="<?= $book->publishing_company ?>">
                        <label class="labelInput" for="publishingCompany">Editora</label>
                    </div>
                    <div class="inputGroup">
                        <input id="ISBN" class="inputUser" type="text" name="ISBN" maxlength="13" value="<?= $book->isbn ?>">
                        <label class="labelInput" for="ISBN">ISBN</label>
                    </div>
                </div>
                <div class="inputRow">
                    <div class="inputGroup">
                        <input id="numberOfPages" class="inputUser" type="number" name="numberOfPages" min="1" value="<?= $book->number_of_pages ?>">
                        <label class="labelInput" for="numberOfPages">Número de Páginas</label>
                    </div>
                    <div id="inputSelect" class="inputGroup">
                        <p>Gênero Literário:</p>
                        <select name="genreID">
                            <option value="null" selected>Sem gênero</option>
                            <?php
                            foreach ($genres as $genre):?>
                                <option value="<?= $genre->id ?>" <?= ($genre->id == $book->genre_id ? "selected" : "") ?>><?= $genre->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div id="inputTextArea">
                    <div class="inputGroupText">
                        <textarea id="synopsis" name="synopsis" rows="5" cols="40" maxlength="800"><?= $book->synopsis ?></textarea>
                        <label class="labelInput" for="synopsis">Sinopse:</label>
                    </div>
                    <div class="inputGroupText">
                        <textarea id="note" name="note" rows="5" cols="40" maxlength="500"><?= $book->note ?></textarea>
                        <label class="labelInput" for="note">Observação:</label>
                    </div>
                    <div class="statusPanel">
                        <h5>Status: <?= ($book->status == 2 ? "<span style='color: #FFC107;'>Em Empréstimo</span>" : "<span style='color: #42EE5E;'>Disponível</span>") ?></h5>
                        <?php
                            if ($loan) {
                                echo "<a style='width: 100%; text-align: center;' class='btn btn-success' href=\"./emprestimo?loanID={$loan->id}\" role='button'>Visualizar</a>";
                            }
                        ?>
                        <h5 style="margin-top: 20px">Código Livro: (<span style="color: #FF0000"><?= $book->getBookCode() ?></span>)</h5>
                    </div>
                </div>
            </div>
            <div class="buttonGroup">
                <input type="submit" name="submit" id="editarBtn" value="EDITAR ALUNO">
                <?php if ($book->status == 2) :?>
                    <a style="width: 80%; height: 35%; text-align: center;" class="btn btn-danger" onclick="return confirm('Não é possível excluir um livro que está emprestado!');" href="#" role="button"><span style="width: 100%; height: 100%; display: flex; justify-content: center; align-items: center">Excluir</span></a>
                <?php else :?>
                    <a style="width: 80%; height: 35%; text-align: center;" class="btn btn-danger" onclick="return confirm('Tem certeza que quer excluir este livro?');" href="../../Controllers/book/deleteController.php?bookID=<?= $bookID ?>" role="button"><span style="width: 100%; height: 100%; display: flex; justify-content: center; align-items: center">Excluir</span></a>
                <?php endif; ?>
            </div>
        </form>
    </main>
<script crossorigin="anonymous"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        src="../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>