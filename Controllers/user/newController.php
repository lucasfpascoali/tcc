<?php

use Source\Core\Message;
use Source\Models\User;

require __DIR__ . '/../login/verifyController.php';
require_once __DIR__ . "/../../autoload.php";

$session = new \Source\Core\Session();

if (empty($_POST)) {
    $message = (new Message())->warning('Dados incompletos');
    $message->flash();
    redirect('views/cadastrar/funcionario.php');
}

$data = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

$worker = (new User())->bootstrap(
    $data['workerFirstName'],
    $data['workerLastName'],
    $data['workerCpf'],
    $data['workerPassword']
);

if ($worker = $worker->save()) {
    $worker->message()->success('Funcionário cadastrado com sucesso');
    $session->set('tempID', $worker->id);
}

$worker->message()->flash();
redirect('views/cadastrar/funcionario.php');
