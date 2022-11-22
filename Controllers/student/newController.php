<?php

use Source\Core\Message;
use Source\Models\Student;

require __DIR__ . '/../login/verifyController.php';
require_once __DIR__ . "/../../autoload.php";

$session = new \Source\Core\Session();

if (empty($_POST)) {
    $message = (new Message())->warning('Dados incompletos');
    $message->flash();
    redirect('views/cadastrar/aluno.php');
}

$studentData = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

$student = (new Student())->bootstrap(
    $studentData['studentFirstName'],
    $studentData['studentLastName'],
    $studentData['studentRegister'],
    $studentData['studentPassword'],
    $studentData['studentBirth']
);

if ($new = $student->save()) {
    $student->message()->success('Aluno cadastrado com sucesso');
    $session->set('tempID', $new->id);
}

$student->message()->flash();
redirect('views/cadastrar/aluno.php');