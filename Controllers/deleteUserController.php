<?php

require __DIR__ . './verifyLoginController.php';
require_once __DIR__ . "/../autoload.php";

$userID = filter_input(INPUT_GET, 'userID', FILTER_VALIDATE_INT);
if (!$userID) {
    redirect("/views/funcionarios.php");
}

$session = new \Source\Core\Session();
if ($userID == $session->login) {
    redirect("/views/funcionarios.php");
}

$user = (new \Source\Models\User())->findById($userID);
if (!$user) {
    redirect("/views/funcionarios.php");
}

$user->destroy();
$user->message()->flash();

redirect("/views/funcionarios.php");
