<?php

namespace Source\Models;

use Source\Core\Model;

class Student extends Model
{
    /** @var string[] $safe no update or create */
    protected static array $safe = ["id", "created_at", "updated_at"];

    /** @var string $entity database table */
    protected static string $entity = "students";

    /** @var string[] $required required fields */
    protected static array $required = ["first_name", "last_name", "registration", "password", "birth_date"];

    public function bootstrap(string $firstName, string $lastName, string $registration, string $password, string $birthDate): ?Student
    {
        $this->first_name = $firstName;
        $this->last_name = $lastName;
        $this->registration = $registration;
        $this->password = $password;
        $this->birth_date = $birthDate;
        return $this;
    }

    /**
     * @param string $terms
     * @param string $params
     * @param string $columns
     * @return Student|null
     */
    public function find(string $terms, string $params, string $columns = "*"): ?Student
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
    public function findById(int $id, string $columns = "*"): ?Student
    {
        return $this->find("id = :id", "id={$id}", $columns);
    }

    /**
     * @param string $registration
     * @param string $columns
     * @return Student|null
     */
    public function findByRegistration(string $registration, string $columns = "*"): ?Student
    {
        return $this->find("registration = :registration", "registration={$registration}", $columns);
    }

    /**
     * @param int $limit
     * @param int $offset
     * @param string $columns
     * @return array|false|null
     */
    public function all(int $limit = 30, int $offset = 0, string $columns = "*"): ?array
    {
        $all = $this->read("SELECT {$columns} FROM " . self::$entity . " ORDER by first_name, last_name LIMIT :limit OFFSET :offset ",
            "limit={$limit}&offset={$offset}");
        if ($this->fail() || !$all->rowCount()) {
            return null;
        }

        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    public function search(string $searchMethod, string $searchValue, string $orderMethod, string $columns = "*"): ?array
    {
        $searchMethod = filter_var($searchMethod, FILTER_SANITIZE_SPECIAL_CHARS);
        if ($searchMethod == 'name') {
            $searchMethod = "concat(first_name, ' ', last_name)";
        }
        $orderMethod = filter_var($orderMethod, FILTER_SANITIZE_SPECIAL_CHARS);
        $search = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE {$searchMethod} LIKE :sv ORDER BY {$orderMethod}",
            "sv={$searchValue}", true);
        if ($this->fail() || !$search->rowCount()) {
            return null;
        }

        return $search->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    public function getActiveLoans($orderMethod = 'expected_return_date'): ?array
    {
        return (new Loan())->findStudentActiveLoans($this->id);
    }

    /**
     * @return $this|null
     */
    public function save(): ?Student
    {
        if (!$this->required()) {
            $this->message->warning("Nome, sobrenome, matrícula, senha e data de nascimento são obrigatórios");
            return null;
        }

        if (!is_passwd($this->password)) {
            $min = CONF_PASSWD_MIN_LEN;
            $max = CONF_PASSWD_MAX_LEN;
            $this->message->warning("A senha deve ter entre {$min} e {$max} caracteres");
            return null;
        }

        $this->password = passwd($this->password);

        /** student Update */
        if (!empty($this->id)) {
            $userId = $this->id;

            if ($this->find("registration = :r AND id != :i", "r={$this->registration}&i={$userId}")) {
                $this->message->warning("A matrícula informada já está cadastrada");
                return null;
            }

            $this->update(self::$entity, $this->safe(), "id = :id", "id={$userId}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return null;
            }
        }

        /** student Create */
        if (empty($this->id)) {
            if ($this->findByRegistration($this->registration)) {
                $this->message->warning("A matrícula informada já está cadastrada");
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
    public function destroy(): ?Student
    {
        if (!empty($this->id)) {
            $this->delete(self::$entity, "id = :id", "id={$this->id}");
        }

        if ($this->fail()) {
            $this->message->error("Não foi possível remover o aluno");
            return null;
        }

        $this->message->success("Aluno removido com sucesso");
        $this->data = null;
        return $this;
    }


    public function count(): int
    {
        $all = $this->read('SELECT * FROM ' . self::$entity);
        return $all->rowCount();
    }
}