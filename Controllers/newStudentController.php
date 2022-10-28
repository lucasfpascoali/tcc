<?php

use Source\Core\Message;
use Source\Models\Student;

require __DIR__ . './verifyLoginController.php';
require_once __DIR__ . "/../autoload.php";

if (empty($_POST)) {
    $message = (new Message())->warning('Dados incompletos');
    $message->flash();
    redirect('views/cadastroAluno.php');
}

$studentData = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

$student = (new Student())->bootstrap(
    $studentData['studentFirstName'],
    $studentData['studentLastName'],
    $studentData['studentRegister'],
    $studentData['studentPassword'],
    $studentData['studentBirth']
);


if ($student->save()) {
    $student->message()->success('Aluno cadastrado com sucesso');
}

$student->message()->flash();
redirect('views/cadastroAluno.php');