<?php

require __DIR__ . '/../login/verifyController.php';
require_once __DIR__ . "/../../autoload.php";

$studentID = filter_input(INPUT_GET, 'studentID', FILTER_VALIDATE_INT);
if (!$studentID) {
    redirect("/views/buscar/alunos.php");
}

$student = (new \Source\Models\Student())->findById($studentID);
if (!$student) {
    redirect("/views/buscar/alunos.php");
}


$student->destroy();
$student->message()->flash();

redirect("/views/buscar/alunos.php");
