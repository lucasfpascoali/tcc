<?php

namespace Source\Models;

use Source\Core\Model;

/**
 *
 */
class Book extends Model
{
    /** @var string[] $safe no update or create */
    protected static array $safe = ["id", "created_at", "updated_at"];

    /** @var string $entity database table */
    protected static string $entity = "books";

    /** @var string[] $required required fields */
    protected static array $required = ["title", "author"];

    /**
     * @param string $title
     * @param string $author
     * @param int $genreId
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
        string $publishingCompany = "",
        string $isbn = "",
        string $synopsis = "",
        string $note = "",
        ?int $numberOfPages = null
    ): ?Book {
        $this->title = $title;
        $this->author = $author;
        $this->genre_id = $genreId;
        $this->publishing_company = $publishingCompany;
        $this->isbn = $isbn;
        $this->synopsis = $synopsis;
        $this->note = $note;
        $this->number_of_pages = $numberOfPages;
        $this->status = 1;
        return $this;
    }

    public function getBookCode(): ?string
    {
        if (!$this->book_code_letter || !$this->book_code_number || !$this->book_example_number) {
            return null;
        }
        return "{$this->book_code_letter}{$this->book_code_number}{$this->book_example_number}";
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
        return $this->find("concat(book_code_letter, book_code_number, book_example_number) = :bc", "bc={$bookCode}", $columns);
    }

    /**
     * @param string $isbn
     * @param string $columns
     * @return Book|null
     */
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
        $all = $this->read("SELECT {$columns} FROM " . self::$entity . " ORDER BY title LIMIT :limit OFFSET :offset ",
            "limit={$limit}&offset={$offset}");
        if ($this->fail() || !$all->rowCount()) {
            return null;
        }

        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    public function search(string $searchMethod, string $searchValue, string $orderMethod, string $columns = "*"): ?array
    {
        $searchMethod = filter_var($searchMethod, FILTER_SANITIZE_SPECIAL_CHARS);
        $orderMethod = filter_var($orderMethod, FILTER_SANITIZE_SPECIAL_CHARS);
        $search = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE {$searchMethod} LIKE :sv ORDER BY {$orderMethod}",
            "sv=%{$searchValue}%");
        if ($this->fail() || !$search->rowCount()) {
            return null;
        }

        return $search->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
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

        /** book Update */
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

        /** user Create */
        if (empty($this->id)) {

            $this->generateBookCode();

            if ($this->isbn != "" && $book = $this->findByISBN($this->isbn)) {
                if ($this->book_code_letter != $book->book_code_letter || $this->book_code_number != $book->book_code_number) {
                    $this->message->warning("O ISBN informado já está cadastrado");
                    return null;
                }
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

    private function generateBookCode(): void
    {
        $bookAlreadyExists = $this->find("title = :t && author = :a ORDER BY book_example_number DESC LIMIT 1",
            "t={$this->title}&a={$this->author}");
        if (!$bookAlreadyExists) {
            $this->book_code_letter = $this->generateBookCodeLetter();
            $this->book_code_number = $this->generateBookCodeNumber();
            $this->book_example_number = 'A';
        } else {
            $this->book_code_letter = $bookAlreadyExists->book_code_letter;
            $this->book_code_number = $bookAlreadyExists->book_code_number;
            $this->book_example_number = chr(ord($bookAlreadyExists->book_example_number) + 1);
        }
    }

    /**
     * @return string
     */
    private function generateBookCodeLetter(): string
    {
        $bookTitle = trim($this->title);
        $authorName = trim($this->author);

        /* Primeira Letra do Título */
        $firstDigit = $bookTitle[0];

        /* Primeira Letra do Último Sobrenome do Autor */
        $authorLastNameStartPosition = strrpos($authorName, " ");
        if (!$authorLastNameStartPosition) {
            // Se não há nenhum espaço no nome do autor, logo só temos um nome na string $authorName
            // Então retornamos direto o primeiro digito
            return "{$firstDigit}{$authorName[0]}";
        }

        $lastDigit = $authorName[$authorLastNameStartPosition + 1];
        return "{$firstDigit}{$lastDigit}";
    }

    /**
     * @return string
     */
    private function generateBookCodeNumber(): string
    {
        $booksWithSameLetterCode = $this->find("book_code_letter = :b ORDER BY book_code_number DESC LIMIT 1",
            "b={$this->book_code_letter}");
        if (!$booksWithSameLetterCode) {
            return '001';
        }

        return str_pad(strval(intval($booksWithSameLetterCode->book_code_number) + 1), 3, '0', STR_PAD_LEFT);;
    }
}