<?php
    $titleOptions = [
            CONF_MESSAGE_SUCCESS => "<span style='color: #42EE5E'>Operação Realizada Com Sucesso!</span>",
            CONF_MESSAGE_WARNING => "<span style='color: #FF0000'>Operação Não Foi Realizada!</span>"
    ];

    $messageTitle = $titleOptions[$message->getType()];
    $session = new \Source\Core\Session();
    $redirectID = $session->tempID;
?>
<div class="modal fade" id="feedBackModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel"><?= $messageTitle ?></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div style="text-align: center" class="modal-body">
                <?= $message->getText(); ?>.
            </div>
            <div style="width: 100%; display: flex; justify-content: center;" class="modal-footer">
                <?php if ($modalRedirect) :?>
                    <a class="btn btn-success" href="<?= "{$modalRedirect}{$redirectID}" ?>" role="button">Visualizar</a>
                <?php endif; ?>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script>
    const myModal = new bootstrap.Modal(document.getElementById('feedBackModal'));
    myModal.show();
</script>