<?php

require_once __DIR__ . "/../autoload.php";

$genreID = filter_input(INPUT_GET, "genreID", FILTER_VALIDATE_INT);

if (!$genreID) {
    redirect("/views/generos.php");
}

$genre = new \Source\Models\Genre();
if (!($genre = $genre->findById($genreID))) {
    redirect("/views/generos.php");
}

$genre = $genre->destroy();
$genre->message()->flash();
redirect("/views/generos.php");