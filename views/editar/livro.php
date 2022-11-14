<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>SAB - Livro</title>
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

        $modalRedirect = null;

        $genres = (new \Source\Models\Genre())->all();

        require __DIR__ . "/../components/nav.php";
    ?>
    <main>
        <form autocomplete="off" action="../../Controllers/book/editController.php" method="post">
            <h2>Atualizar Livro:</h2>
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
                        <?php if ($loan) :?>
                            <button style="width: 100%;" type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#loanModal">
                                Visualizar
                            </button>
                            <?php

                            $book = $loan->getBook();
                            $student = $loan->getStudent();

                            $loanDate = (new DateTime($loan->loan_date))->format(CONF_DATE_BR);
                            $loanReturnDate = (new DateTime($loan->expected_return_date))->format(CONF_DATE_BR);

                            ?>
                            <div class="modal fade" id="loanModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Empréstimo em andamento: <?= $loan->renderLoanStatus() ?></h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><a href="./aluno.php?studentID=<?= $student->id ?>">Aluno: <?= "{$student->first_name} {$student->last_name} - Matrícula: {$student->registration}" ?></a></p>
                                            <p><a href="#">Livro: <?= "{$book->title} - Autor: {$book->author} ({$book->getBookCode()}) " ?></a></p>
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
                                            <a style="width: 30%" class="btn btn-success" href="../../Controllers/loan/finishController.php?loanID=<?= $loan->id ?>&redirect=livro" role="button">Finalizar</a>
                                            <a style="width: 30%; --bs-btn-color: #fff; --bs-btn-hover-color: #fff;" class="btn btn-info" href="../../Controllers/loan/renewController.php?loanID=<?= $loan->id ?>&redirect=livro" role="button">Renovar </a>
                                            <a style="width: 30%" class="btn btn-danger" href="../../Controllers/loan/deleteController.php?loanID=<?= $loan->id ?>&redirect=livro" onclick="return confirm('Tem certeza que quer excluir esse empréstimo?');" role="button">Excluir</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <h5 style="margin-top: 20px">Código Livro: (<span style="color: #FF0000"><?= $book->getBookCode() ?></span>)</h5>
                    </div>
                </div>
            </div>
            <div class="buttonGroup">
                <input type="submit" name="submit" id="editarBtn" value="EDITAR LIVRO">
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
    <?php
        $showModal = filter_input(INPUT_GET, 'showModal', FILTER_VALIDATE_INT);
        if ($showModal && $loan) :?>
        <script>
            const myModal = new bootstrap.Modal(document.getElementById('loanModal'));
            myModal.show();
        </script>

    <?php endif; ?>
    <?php
        if ($message) {
            require __DIR__ . "/../components/feedBackModal.php";
        }
    ?>
</body>
</html>