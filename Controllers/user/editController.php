<?php

use Source\Core\Message;
use Source\Core\Session;
use Source\Models\User;

require __DIR__ . '/../login/verifyController.php';
require_once __DIR__ . "/../../autoload.php";

$session = new Session();
$userID = $session->login;

$user = (new User())->findById($userID);
if (!$user) {
    redirect("views/editar/funcionario.php");
}

if (empty($_POST)) {
    $message = (new Message())->warning('Dados incompletos');
    $message->flash();
    redirect("views/editar/funcionario.php");
}

$userData = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

$user->first_name = $userData['workerFirstName'];
$user->last_name = $userData['workerLastName'];
$user->cpf = $userData['workerCpf'];
if ($userData['workerPassword']) {
    if ($userData['workerPassword'] == $userData['workerPasswordVerify']) {
        $user->password = $userData['workerPassword'];
    } else {
        $message = (new Message())->warning('As senhas não coincidem!');
        $message->flash();
        redirect("views/editar/funcionario.php");
    }
}

if ($user->save()) {
    $user->message()->success('Seus dados foram atualizados com sucesso');
}

$user->message()->flash();
redirect("views/editar/funcionario.php");