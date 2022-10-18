<?php

namespace Source\Models;

use Source\Core\Model;

class Book extends Model
{
    /** @var string[] $safe no update or create */
    protected static array $safe = ["id", "created_at", "updated_at"];

    /** @var string $entity database table */
    protected static string $entity = "books";

    /** @var string[] $required required fields */
    protected static array $required = ["title", "author", "genre", "book_code"];

    /**
     * @param string $title
     * @param string $author
     * @param int $genreId
     * @param int $bookCode
     * @param string|null $publishingCompany
     * @param string|null $isbn
     * @param string|null $synopsis
     * @param string|null $note
     * @param int|null $numberOfPages
     * @return $this|null
     */
    public function bootstrap(
        string $title,
        string $author,
        int $genreId,
        int $bookCode,
        string $publishingCompany = "",
        string $isbn = "",
        string $synopsis = "",
        string $note = "",
        ?int $numberOfPages = null
    ): ?Book {
        $this->title = $title;
        $this->author = $author;
        $this->genre_id = $genreId;
        $this->book_code = $bookCode;
        $this->publishing_company = $publishingCompany;
        $this->isbn = $isbn;
        $this->synopsis = $synopsis;
        $this->note = $note;
        $this->number_of_pages = $numberOfPages;
        $this->status = 1;
        return $this;
    }

    /**
     * @param string $terms
     * @param string $params
     * @param string $columns
     * @return Student|null
     */
    public function find(string $terms, string $params, string $columns = "*"): ?Book
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
     * @return Book|null
     */
    public function findById(int $id, string $columns = "*"): ?Book
    {
        return $this->find("id = :id", "id={$id}", $columns);
    }

    /**
     * @param string $bookCode
     * @param string $columns
     * @return Book|null
     */
    public function findByBookCode(string $bookCode, string $columns = "*"): ?Book
    {
        return $this->find("book_code = :bc", "bc={$bookCode}", $columns);
    }

    public function findByISBN(string $isbn, string $columns = "*"): ?Book
    {
        return $this->find("isbn = :i", "i={$isbn}", $columns);
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
     * @return Book|null
     */
    public function save(): ?Book
    {
        if (!$this->required()) {
            $this->message->warning("Título, autor e gênero são obrigatórios");
            return null;
        }

        // TODO: Fazer método que verifica e cria o código do Livro

        /** Book Update */
        if (!empty($this->id)) {
            $userId = $this->id;

            if ($this->isbn != "" && $this->find("isbn = :isbn AND id != :i", "isbn={$this->isbn}&i={$userId}")) {
                $this->message->warning("O isbn informado já está cadastrado");
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
            if ($this->isbn != "" && $this->findByISBN($this->isbn)) {
                $this->message->warning("O ISBN informado já está cadastrado");
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
    public function destroy(): ?Book
    {
        if (!empty($this->id)) {
            $this->delete(self::$entity, "id = :id", "id={$this->id}");
        }

        if ($this->fail()) {
            $this->message->error("Não foi possível remover o livro");
            return null;
        }

        $this->message->success("Livro removido com sucesso");
        $this->data = null;
        return $this;
    }
}