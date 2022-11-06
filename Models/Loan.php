<?php

namespace Source\Models;

use Source\Core\Session;

class Loan extends \Source\Core\Model
{
    /** @var string[] $safe no update or create */
    protected static array $safe = ["id", "created_at", "updated_at"];

    /** @var string $entity database table */
    protected static string $entity = "loans";

    /** @var string[] $required required fields */
    protected static array $required = ["book_id", "student_id", "loan_date", "expected_return_date"];

    public function bootstrap(string $loanDate, string $expectedReturnDate, int $bookID, int $studentID, string $obs = ""): ?Loan
    {
        $this->loan_date = $loanDate;
        $this->expected_return_date = $expectedReturnDate;
        $this->book_id = $bookID;
        $this->student_id = $studentID;
        $this->return_date = null;
        $this->obs = $obs;
        return $this;
    }

    public function getStudent(): ?Student
    {
        return (new Student())->findById($this->student_id);
    }

    public function getBook(): ?Book
    {
        return (new Book())->findById($this->book_id);
    }

    public function getRemainingDays(): int
    {
        $today = new \DateTime('today');
        $expectedDate = new \DateTime($this->expected_return_date);

        return ($today->diff($expectedDate)->invert ? -1 : $today->diff($expectedDate)->d);
    }

    public function renderLoanStatus(): string
    {
        $remainingDays = $this->getRemainingDays();

        if ($remainingDays > 1) {
            return "<span style='color: #FFC107; text-align: center;'>{$remainingDays} dias restantes</span>";
        } else if ($remainingDays == 1) {
            return "<span style='color: #FFC107; text-align: center;'>{$remainingDays} dia restante</span>";
        } else if ($remainingDays == 0) {
            return "<span style='color: #FFC107; text-align: center;'>Último dia do empréstimo</span>";
        } else {
            return "<span style='color: #FF0000; text-align: center;'>Empréstimo vencido</span>";
        }
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

    public function findByStudentId(int $studentId, string $orderMethod = "expected_return_date", string $columns = "*"): ?array
    {
        $find = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE student_id = :student_id ORDER BY {$orderMethod}",
        "student_id={$studentId}");
        if ($this->fail() || !$find->rowCount()) {
            return null;
        }

        return $find->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    public function findByBookId(int $bookId, string $orderMethod = "expected_return_date", string $columns = "*"): ?Loan
    {
        $find = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE book_id = :book_id AND isnull(return_date) ORDER BY {$orderMethod}",
            "book_id={$bookId}");
        if ($this->fail() || !$find->rowCount()) {
            return null;
        }

        return $find->fetchObject(__CLASS__);
    }

    /**
     * @param int $limit
     * @param int $offset
     * @param string $columns
     * @return array|false|null
     */
    public function all(int $limit = 30, int $offset = 0, string $columns = "*"): ?array
    {
        $all = $this->read("SELECT {$columns} FROM " . self::$entity . " ORDER BY expected_return_date LIMIT :limit OFFSET :offset ",
            "limit={$limit}&offset={$offset}");
        if ($this->fail() || !$all->rowCount()) {
            return null;
        }

        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    public function searchActiveLoans(string $orderMethod = 'expected_return_date',string $columns = "*"): ?array
    {
        $orderMethod = filter_var($orderMethod, FILTER_SANITIZE_SPECIAL_CHARS);
        $search = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE isnull(return_date) ORDER BY {$orderMethod} ");
        if ($this->fail() || !$search->rowCount()) {
            return null;
        }
        return $search->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    public function search(int $searchMethod, string $searchValue, string $orderMethod, string $columns = '*'): ?array
    {
        $orderMethod = filter_var($orderMethod, FILTER_SANITIZE_SPECIAL_CHARS);
        if ($searchMethod <= 2) {
            $argument = ($searchMethod == 1 ? "concat(first_name, ' ' ,last_name)" : 'students.registration');
            return $this->searchByStudent($argument, $searchValue, $orderMethod, $columns);
        } else if ($searchMethod <= 4) {
            $argument = ($searchMethod == 3 ? 'books.title' : 'concat(book_code_letter, book_code_number, book_example_number)');
            return $this->searchByBook($argument, $searchValue, $orderMethod, $columns);
        } else {
            return null;
        }
    }

    public function searchByStudent(string $searchMethod, string $searchValue, string $orderMethod, string $columns = "*"): ? array
    {
        if ($orderMethod != "first_name ASC, last_name ASC" && $orderMethod != "first_name DESC, last_name DESC"
            && $orderMethod != "loan_date ASC" && $orderMethod != "loan_date DESC"
            && $orderMethod != "expected_return_date ASC" && $orderMethod != "expected_return_date DESC") {
            $orderMethod = "first_name ASC, last_name ASC";
        }

        $search = $this->read("SELECT {$columns} FROM " . self::$entity . " INNER JOIN students on loans.student_id = students.id WHERE {$searchMethod} LIKE :sv ORDER BY {$orderMethod}",
            "sv=%{$searchValue}%");
        if ($this->fail() || !$search->rowCount()) {
            return null;
        }

        return $search->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    public function searchByBook(string $searchMethod, string $searchValue, string $orderMethod, string $columns = "*"): ? array
    {
        if ($orderMethod != "book_code_letter ASC, book_code_number ASC, book_example_number ASC"
            && $orderMethod != "book_code_letter DESC, book_code_number DESC, book_example_number DESC"
            && $orderMethod != "title DESC" && $orderMethod != "loan_date ASC" && $orderMethod != "loan_date DESC"
            && $orderMethod != "expected_return_date ASC" && $orderMethod != "expected_return_date DESC") {
            $orderMethod = "title ASC";
        }

        $search = $this->read("SELECT {$columns} FROM " . self::$entity . " INNER JOIN books on loans.book_id = books.id WHERE {$searchMethod} LIKE :sv ORDER BY {$orderMethod}",
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
        if (!$this->required()) {
            $this->message->warning("Livro, aluno, data de empréstimo e data prevista de devolução são obrigatórios");
            return null;
        }

        /** loan Update */
        if (!empty($this->id)) {
            $userId = $this->id;

            $this->update(self::$entity, $this->safe(), "id = :id", "id={$userId}");
            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return null;
            }
        }

        /** loan Create */
        if (empty($this->id)) {
            $userId = $this->create(self::$entity, $this->safe());
            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados");
                return null;
            }
        }

        $book = (new Book())->findById($this->book_id);
        $book->status = 2;
        if (!$book->save()) {
            $this->message->warning("Erro ao atualizar o livro, tente novamente");
            return null;
        }

        $session = (new Session());
        $session->unset('bookID');
        $session->unset('studentID');

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
}