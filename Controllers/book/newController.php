<?php

use Source\Core\Message;
use Source\Models\Book;

require __DIR__ . '/../login/verifyController.php';
require_once __DIR__ . "/../../autoload.php";

$session = new \Source\Core\Session();

if (empty($_POST)) {
    $message = (new Message())->warning('Dados incompletos');
    $message->flash();
    redirect('views/cadastrar/livro.php');
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

if ($book = $book->save()) {
    $book->message()->success('Livro cadastrado com sucesso');
    $session->set('tempID', $book->id);
}

$book->message()->flash();
redirect("views/cadastrar/livro.php");
