<?php

use Source\Models\Loan;

require __DIR__ . "/../login/verifyController.php";
require_once __DIR__ . "/../../autoload.php";

$message = new \Source\Core\Message();
$session = new \Source\Core\Session();


$loanID = filter_input(INPUT_GET, 'loanID', FILTER_VALIDATE_INT);
if (!$loanID) {
    redirect('views/index.php');
}

$redirect = filter_input(INPUT_GET, 'redirect', FILTER_DEFAULT);
if (!$redirect) {
    $redirect = 'index';
}

$loan = (new Loan())->findById($loanID);
if (!$loan || $loan->return_date) {
    redirect('views/index.php');
}

$redirectLinks = [
    "buscar" => "views/buscar/emprestimos.php",
    "index" => "views/index.php",
    "livro" => "views/editar/livro.php?bookID={$loan->book_id}",
    "aluno" => "views/editar/aluno.php?studentID={$loan->student_id}"
];

$redirect = $redirectLinks[$redirect];


$book = $loan->getBook();
$book->status = 1;
if (!$book->save()) {
    redirect($redirect);
}

$loan->destroy();
redirect($redirect);
