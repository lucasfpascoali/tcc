<?php

use Source\Core\Message;
use Source\Models\User;

require __DIR__ . './verifyLoginController.php';
require_once __DIR__ . "/../autoload.php";

if (empty($_POST)) {
    $message = (new Message())->warning('Dados incompletos');
    $message->flash();
    redirect('views/cadastroFuncionario.php');
}

$data = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

$worker = (new User())->bootstrap(
    $data['workerFirstName'],
    $data['workerLastName'],
    $data['workerCpf'],
    $data['workerPassword']
);

if ($worker->save()) {
    $worker->message()->success('Funcionário cadastrado com sucesso');
}

$worker->message()->flash();
redirect('views/cadastroFuncionario.php');
