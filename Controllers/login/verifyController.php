<?php

require __DIR__ . "/../../autoload.php";

$session = new \Source\Core\Session();

if (!$session->login) {
    redirect('views/login.php');
}