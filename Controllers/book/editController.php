<?php

use Source\Core\Message;
use Source\Core\Session;
use Source\Models\Book;

require __DIR__ . '/../login/verifyController.php';
require_once __DIR__ . "/../../autoload.php";

$session = new Session();
if (!$session->has('editBookID')) {
    redirect('views/buscar/livros.php');
}

$bookID = $session->editBookID;

if (empty($_POST)) {
    $message = (new Message())->warning('Dados incompletos');
    $message->flash();
    redirect("views/editar/livro.php?bookID={$bookID}");
}

$bookData = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

$book = (new Book())->findById($bookID);
if (!$bookID) {
    redirect('views/buscar/livros.php');
}

$book->title = $bookData['bookTitle'];
$book->author = $bookData['bookAuthor'];
$book->publishing_company = $bookData['publishingCompany'];
$book->isbn = $bookData['ISBN'];
$book->number_of_Pages = $bookData['numberOfPages'];
$book->genre_id = intval($bookData['genreID']);
$book->synopsis = $bookData['synopsis'];
$book->note = $bookData['note'];

if ($book->save()) {
    $book->message()->success('Livro atualizado com sucesso');
}

$book->message()->flash();
$session->unset('editBookID');
redirect("views/editar/livro.php?bookID={$bookID}");
