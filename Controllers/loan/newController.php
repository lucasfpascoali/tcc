<?php

require __DIR__ . "/../login/verifyController.php";
require_once __DIR__ . "/../../autoload.php";

$message = new \Source\Core\Message();
$session = new \Source\Core\Session();

if (empty($_POST)) {
    $message->warning('Dados Incompletos')->flash();
    redirect('views/cadastrar/emprestimo.php');
}

if (!$session->has('bookID') || !$session->has('studentID')) {
    redirect('views/cadastrar/emprestimo.php');
}

$book = (new \Source\Models\Book())->findById($session->bookID);
if (!$book) {
    $message->warning('Livro inválido')->flash();
    redirect('views/cadastrar/emprestimo.php');
}
if ($book->status != 1) {
    $message->warning('Livro já está em um empréstimo pendente')->flash();
    redirect('views/cadastrar/emprestimo.php');
}

$student = (new \Source\Models\Student())->findById($session->studentID);
if (!$student) {
    $message->warning('Aluno inválido')->flash();
    redirect('views/cadastrar/emprestimo.php');
}

$data = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

if (!passwd_verify($data['studentPassword'], $student->password)) {
    $message->warning('A senha do aluno está incorreta')->flash();
    redirect('views/cadastrar/emprestimo.php');
}

try {
    $loanDate = new DateTime($data['loanDate']);
} catch (Exception $e) {
    redirect('views/cadastrar/emprestimo.php');
}
try {
    $expectedDate = new DateTime($data['expectedReturnDate']);
} catch (Exception $e) {
    redirect('views/cadastrar/emprestimos.php');
}

if ($loanDate->diff($expectedDate)->invert) {
    redirect('views/cadastrar/emprestimo.php');
}

$data['expectedReturnDate'] = (new DateTime($data['loanDate']))->modify('+15 days');

$loan = (new \Source\Models\Loan())->bootstrap(
    $data['loanDate'],
    $data['expectedReturnDate']->format('Y-m-d'),
    $session->bookID,
    $session->studentID,
    $data['obs']
);

if ($loan = $loan->save()) {
    $loan->message()->success('Empréstimo realizado com sucesso');
    $book = $loan->getBook();
    $book->status = 2;
    $book->save();
    $session->set('tempID', $loan->id);
}

$loan->message()->flash();
redirect("views/cadastrar/emprestimo.php");






