<?php

use Source\Core\Message;
use Source\Core\Session;
use Source\Models\Student;

require __DIR__ . '/../login/verifyController.php';
require_once __DIR__ . "/../../autoload.php";

$session = new Session();
if (!$session->has('editStudentID')) {
    redirect('views/buscar/alunos.php');
}

$studentID = $session->editStudentID;

if (empty($_POST)) {
    $message = (new Message())->warning('Dados incompletos');
    $message->flash();
    redirect("views/editar/aluno.php?studentID={$studentID}");
}

$studentData = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

$student = (new Student())->findById($studentID);
if (!$student) {
    redirect('views/buscar/alunos.php');
}

$student->first_name = $studentData['studentFirstName'];
$student->last_name = $studentData['studentLastName'];
$student->registration = $studentData['studentRegister'];
$student->birth_date = $studentData['studentBirth'];
if ($studentData['studentPassword']) {
    $student->password = $studentData['studentPassword'];
}

if ($student->save()) {
    $student->message()->success('Aluno atualizado com sucesso');
}

$student->message()->flash();
$session->unset('editStudentID');
redirect("views/editar/aluno.php?studentID={$studentID}");
