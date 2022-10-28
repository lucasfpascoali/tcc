<div class="resultPanel">
    <?php
    foreach ($users as $user) :?>
        <span class="resultRow">
        <p><a href="./cadastroFuncionario.php?userID=<?= $user->id ?>"><?= "{$user->first_name} {$user->last_name} - CPF: {$user->cpf}" ?></a></p>
        <a onclick="return confirm('Tem certeza que quer excluir este funcionário?');" style="margin-bottom: 5px;" class="btn btn-danger" href="../Controllers/deleteUserController.php?userID=<?= $user->id ?>" role="button">Excluir</a>
    </span>
    <?php endforeach; ?>
</div>