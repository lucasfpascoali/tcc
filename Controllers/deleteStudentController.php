<?php

require __DIR__ . './verifyLoginController.php';
require_once __DIR__ . "/../autoload.php";

$studentID = filter_input(INPUT_GET, 'studentID', FILTER_VALIDATE_INT);
if (!$studentID) {
    redirect("/views/alunos.php");
}

$student = (new \Source\Models\Student())->findById($studentID);
if (!$student) {
    redirect("/views/alunos.php");
}


$student->destroy();
$student->message()->flash();

redirect("/views/alunos.php");
