<?php

require __DIR__ . '/../login/verifyController.php';
require_once __DIR__ . "/../../autoload.php";

$genreID = filter_input(INPUT_GET, "genreID", FILTER_VALIDATE_INT);

if (!$genreID) {
    redirect("/views/editar/generos.php");
}

$genre = (new \Source\Models\Genre())->findById($genreID);
if (!$genre) {
    redirect("/views/editar/generos.php");
}

$genre->destroy();

$genre->message()->flash();
redirect("/views/editar/generos.php");