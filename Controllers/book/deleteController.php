<?php

require __DIR__ . '/../login/verifyController.php';
require_once __DIR__ . "/../../autoload.php";

$bookID = filter_input(INPUT_GET, 'bookID', FILTER_VALIDATE_INT);
if (!$bookID) {
    redirect("/views/buscar/livros.php");
}

$book = (new \Source\Models\Book())->findById($bookID);
if (!$book) {
    redirect("/views/buscar/livros.php");
}


$book->destroy();
$book->message()->flash();

redirect("/views/buscar/livros.php");
