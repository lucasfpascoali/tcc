<?php

use Source\Core\Message;
use Source\Models\Book;

require_once __DIR__ . "/../autoload.php";

if (empty($_POST)) {
    $message = (new Message())->warning('Dados incompletos');
    $message->flash();
    redirect('views/cadastroBook.php');
}

$data = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
if (!$data['numberOfPages']) {
    $data['numberOfPages'] = null;
}

$book = (new Book())->bootstrap(
    $data['bookTitle'],
    $data['bookAuthor'],
    intval($data['genreID']),
    $data['publishingCompany'],
    $data['ISBN'],
    $data['synopsis'],
    $data['note'],
    $data['numberOfPages']
);

if ($book->save()) {
    $book->message()->success('Livro cadastrado com sucesso');
}

var_dump($book->message(), $book->fail());

//$book->message()->flash();
//redirect("views/cadastroLivro.php");

