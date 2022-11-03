<?php

require_once __DIR__ . "/../../autoload.php";

$session = new \Source\Core\Session();
$session->destroy();

redirect("/views/login.php");