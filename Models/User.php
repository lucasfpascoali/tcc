<?php

namespace Source\Models;

class User extends \Source\Core\Model
{
    /** @var string[] $safe no update or create */
    protected static array $safe = ["id", "created_at", "updated_at"];

    /** @var string $entity database table */
    protected static string $entity = "users";

    /** @var string[] $required required fields */
    protected static array $required = ["first_name", "last_name", "cpf", "password"];

    public function bootstrap(string $firstName, string $lastName, string $cpf, string $password): ?User
    {
        $this->first_name = $firstName;
        $this->last_name = $lastName;
        $this->cpf = $cpf;
        $this->password = $password;
        return $this;
    }

    /**
     * @param string $terms
     * @param string $params
     * @param string $columns
     * @return Student|null
     */
    public function find(string $terms, string $params, string $columns = "*"): ?User
    {
        $find = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE {$terms}", $params);
        if ($this->fail() || !$find->rowCount()) {
            return null;
        }

        return $find->fetchObject(__CLASS__);
    }

    /**
     * @param int $id
     * @param string $columns
     * @return Student|null
     */
    public function findById(int $id, string $columns = "*"): ?User
    {
        return $this->find("id = :id", "id={$id}", $columns);
    }

    /**
     * @param string $registration
     * @param string $columns
     * @return Student|null
     */
    public function findByCpf(string $cpf, string $columns = "*"): ?User
    {
        return $this->find("cpf = :cpf", "cpf={$cpf}", $columns);
    }

    /**
     * @param int $limit
     * @param int $offset
     * @param string $columns
     * @return array|false|null
     */
    public function all(int $limit = 30, int $offset = 0, string $columns = "*"): ?array
    {
        $all = $this->read("SELECT {$columns} FROM " . self::$entity . " LIMIT :limit OFFSET :offset ",
            "limit={$limit}&offset={$offset}");
        if ($this->fail() || !$all->rowCount()) {
            return null;
        }

        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    /**
     * @return $this|null
     */
    public function save(): ?User
    {
        if (!$this->required()) {
            $this->message->warning("Nome, sobrenome, CPF e senha são obrigatórios");
            return null;
        }

        if (!is_passwd($this->password)) {
            $min = CONF_PASSWD_MIN_LEN;
            $max = CONF_PASSWD_MAX_LEN;
            $this->message->warning("A senha deve ter entre {$min} e {$max} caracteres");
            return null;
        }

        if (!is_cpf($this->cpf)) {
            $this->message->warning("O CPF informado é inválido! Digite apenas números");
        }

        $this->password = passwd($this->password);

        /** User Update */
        if (!empty($this->id)) {
            $userId = $this->id;

            if ($this->find("cpf = :c AND id != :i", "c={$this->cpf}&i={$userId}")) {
                $this->message->warning("O CPF informado já está cadastrado");
                return null;
            }

            $this->update(self::$entity, $this->safe(), "id = :id", "id={$userId}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return null;
            }
        }

        /** User Create */
        if (empty($this->id)) {
            if ($this->findByCpf($this->cpf)) {
                $this->message->warning("O CPF informado já está cadastrado");
                return null;
            }

            $userId = $this->create(self::$entity, $this->safe());
            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return null;
            }
        }

        $this->data = ($this->findById($userId))->data();
        return $this;
    }

    /**
     * @return $this|null
     */
    public function destroy(): ?User
    {
        if (!empty($this->id)) {
            $this->delete(self::$entity, "id = :id", "id={$this->id}");
        }

        if ($this->fail()) {
            $this->message->error("Não foi possível remover o usuário");
            return null;
        }

        $this->message->success("Usuário removido com sucesso");
        $this->data = null;
        return $this;
    }
}