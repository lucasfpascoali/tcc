<?php

require __DIR__ . "/../autoload.php";

use Source\Core\Message;
use Source\Core\Session;

$message = new Message();
$session = new Session();

if (empty($_POST)) {
    $message->warning('Dados incompletos');
    $message->flash();
    redirect('views/login.php');
}

$loginData = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
if (!is_cpf($loginData['userCpf'])) {
    $message->warning('O CPF informado é inválido! Digite apenas números');
    $message->flash();
    redirect('views/login.php');
}

$user = (new \Source\Models\User())->findByCpf($loginData['userCpf']);
if (!$user) {
    $message->warning('O CPF informado não corresponde a nenhum usuário');
    $message->flash();
    redirect('views/login.php');
}

if (!passwd_verify($loginData['userPassword'], $user->password)) {
    $message->warning('Senha incorreta! Tente novamente');
    $message->flash();
    redirect('views/login.php');
}

$session->set('login', $user->id);
redirect('views/index.php');
