<?php
require __DIR__ . "/autoload.php";

$user = new \Source\Models\User();
$user->bootstrap('Lucas', 'Furlanetto Pascoali', '11025932900', '12345678');
if (!$user->save()) {
    echo $user->fail();
} else {
    echo 'cadastro sucesso';
}
