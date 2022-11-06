<?php

namespace Source\Core;

class Message
{
    private string $text;
    private string $type;

    public function __toString(): string
    {
        return $this->render();
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    public function info(string $message): Message
    {
        $this->type = CONF_MESSAGE_INFO;
        $this->text = $this->filter($message);
        return $this;
    }

    public function success(string $message): Message
    {
        $this->type = CONF_MESSAGE_SUCCESS;
        $this->text = $this->filter($message);
        return $this;
    }

    public function warning(string $message): Message
    {
        $this->type = CONF_MESSAGE_WARNING;
        $this->text = $this->filter($message);
        return $this;
    }

    public function error(string $message): Message
    {
        $this->type = CONF_MESSAGE_ERROR;
        $this->text = $this->filter($message);
        return $this;
    }

    public function render(): string
    {
        return "<span class='" . CONF_MESSAGE_CLASS . " {$this->getType()} '>{$this->getText()}</span>";
    }

    public function renderModal(): string
    {
        $modalTitle = ($this->getType() == CONF_MESSAGE_SUCCESS) ? 'Operação realizada com sucesso' : 'Erro ao efetuar operação';
        return "<div class='modal fade' id='feedBackModal' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h1 class='modal-title fs-5' id='feedBackModalLabel'>{$modalTitle}</h1>
                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                            </div>
                            <div class='modal-body " . CONF_MESSAGE_CLASS . "{$this->getType()}'>
                                {$this->getText()};
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Okay</button>
                            </div>
                        </div>
                    </div>
                </div>
                ";
    }

    public function json(): string
    {
        return json_encode(["error" => $this->getText()]);
    }

    public function flash()
    {
        (new Session())->set("flash", $this);
    }

    private function filter(string $message): string
    {
        return filter_var($message, FILTER_SANITIZE_SPECIAL_CHARS);
    }


}