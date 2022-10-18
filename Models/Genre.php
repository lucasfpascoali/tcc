<?php

namespace Source\Models;

use Source\Core\Model;

class Genre extends Model
{
    /** @var string[] $safe no update or create */
    protected static array $safe = ["id", "created_at", "updated_at"];

    /** @var string $entity database table */
    protected static string $entity = "genres";

    /** @var string[] $required required fields */
    protected static array $required = ["name"];

    /**
     * @param string $name
     * @return $this|null
     */
    public function bootstrap(string $name): ?Genre
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $terms
     * @param string $params
     * @param string $columns
     * @return Genre|null
     */
    public function find(string $terms, string $params, string $columns = "*"): ?Genre
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
     * @return Genre|null
     */
    public function findById(int $id, string $columns = "*"): ?Genre
    {
        return $this->find("id = :id", "id={$id}", $columns);
    }

    /**
     * @param int $limit
     * @param int $offset
     * @param string $columns
     * @return array|false|null
     */
    public function all(int $limit = 30, int $offset = 0, string $columns = "*"): ?array
    {
        $all = $this->read("SELECT {$columns} FROM " . self::$entity . " ORDER BY name LIMIT :limit OFFSET :offset",
            "limit={$limit}&offset={$offset}");
        if ($this->fail() || !$all->rowCount()) {
            return null;
        }

        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    /**
     * @return $this|null
     */
    public function save(): ?Genre
    {
        if (!$this->required()) {
            $this->message->warning("Nome do gênero literário é obrigatório");
            return null;
        }

        /** Genre Update */
        if (!empty($this->id)) {
            $userId = $this->id;

            if ($this->find("name = :n AND id != :i", "n={$this->name}&i={$userId}")) {
                $this->message->warning("Este nome de gênero literário já pertence a outro gênero");
                return null;
            }

            $this->update(self::$entity, $this->safe(), "id = :id", "id={$userId}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return null;
            }
        }

        /** Genre Create */
        if (empty($this->id)) {
            if ($this->find("name = :n", "n={$this->name}")) {
                $this->message->warning("Este gênero literário já está cadastrado");
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
    public function destroy(): ?Genre
    {
        if (!empty($this->id)) {
            $this->delete(self::$entity, "id = :id", "id={$this->id}");
        }

        if ($this->fail()) {
            $this->message->error("Não foi possível remover esse gênero");
            return null;
        }

        $this->message->warning("Gênero literário removido com sucesso");
        $this->data = null;
        return $this;
    }
}