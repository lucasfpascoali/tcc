<?php

require_once __DIR__ . "/../autoload.php";

if (empty($_POST)) {
    $message = (new Message())->warning('Digite o nome do Gênero');
    $message->flash();
    redirect('views/generos.php');
}

$data = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

$genre = new \Source\Models\Genre();
$editGenreID = filter_input(INPUT_GET, "genreID", FILTER_VALIDATE_INT);
if (!$editGenreID) {
    $genre = $genre->bootstrap($data["genreName"]);
} else {
    $genre = $genre->findById($editGenreID);
    $genre->name = $data["genreName"];
}

if ($genre->save()) {
    $genre->message()->success('Gênero cadastrado com sucesso');
}

$genre->message()->flash();
redirect('views/generos.php');
