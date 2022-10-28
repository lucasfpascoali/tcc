<?php

namespace Source\Models;

class Loan extends \Source\Core\Model
{
    /** @var string[] $safe no update or create */
    protected static array $safe = ["id", "created_at", "updated_at"];

    /** @var string $entity database table */
    protected static string $entity = "loans";

    /** @var string[] $required required fields */
    protected static array $required = ["book_id", "student_id", "loan_date", "expected_return_date"];

    public function bootstrap(string $loanDate, string $expectedReturnDate, int $bookID, int $studentID): ?Loan
    {
        $this->loan_date = $loanDate;
        $this->expected_return_date = $expectedReturnDate;
        $this->book_id = $bookID;
        $this->student_id = $studentID;
        $this->return_date = null;
        return $this;
    }

    /**
     * @param string $terms
     * @param string $params
     * @param string $columns
     * @return Student|null
     */
    public function find(string $terms, string $params, string $columns = "*"): ?Loan
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
    public function findById(int $id, string $columns = "*"): ?Loan
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
        $all = $this->read("SELECT {$columns} FROM " . self::$entity . " ORDER BY first_name, last_name LIMIT :limit OFFSET :offset ",
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
            "sv=%{$searchValue}%");
        if ($this->fail() || !$search->rowCount()) {
            return null;
        }

        return $search->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    /**
     * @return $this|null
     */
    public function save(): ?Loan
    {
        $book = (new Book())->findById($this->book_id);
        $student = (new Student())->findById($this->student_id);

        if (!$this->required() || !$book || !$student) {
            $this->message->warning("Livro, aluno, data de empréstimo e data prevista de devolução são obrigatórios");
            return null;
        }

        $book = $this->verifyBookStatus($book);
        if (!$book) {
            return null;
        }

        /** User Update */
        if (!empty($this->id)) {
            $userId = $this->id;

            $this->update(self::$entity, $this->safe(), "id = :id", "id={$userId}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return null;
            }
        }

        /** User Create */
        if (empty($this->id)) {
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
    public function destroy(): ?Loan
    {
        if (!empty($this->id)) {
            $this->delete(self::$entity, "id = :id", "id={$this->id}");
        }

        if ($this->fail()) {
            $this->message->error("Não foi possível remover o empréstimo");
            return null;
        }

        $this->message->success("Empréstimo removido com sucesso");
        $this->data = null;
        return $this;
    }

    private function verifyBookStatus(Book $book): ?Book
    {
        if ($book->status == 0) {
            $this->message->warning("Este livro está em um empréstimo pendente");
            return null;
        }

        $book->status = 0;

        $book->save();
        if ($book->fail()){
            $this->message->warning("Erro ao cadastrar, tente novamente");
            return null;
        }

        return $book;
    }
}