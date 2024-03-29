<?php
    require_once __DIR__ . "/../../autoload.php";
    $session = new \Source\Core\Session();
    $user = (new \Source\Models\User())->findById($session->login);
?>
<nav class="navbar navbar-expand-lg navbar bg-white">
    <div class="container-fluid">
        <h1 id="navTitle"><a href="/tcc/src/views/index.php">E.E.B Apolônio Ireno Cardoso</a></h1>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a aria-expanded="false" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#"
                       role="button">
                        Olá, <?= $user->first_name ?>!
                    </a>
                    <ul class="dropdown-menu dropdown-menu">
                        <li><a class="dropdown-item" href="/tcc/src/views/editar/funcionario.php">Meus Dados</a></li>
                        <li><a class="dropdown-item" href="/tcc/src/views/relatorio.php">Relatórios</a></li>
                        <li><a class="dropdown-item" href="/tcc/src/views/editar/generos.php">Gêneros Literários</a></li>
                        <li><a class="dropdown-item" href="/tcc/src/Controllers/login/logOutController.php">Sair</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>