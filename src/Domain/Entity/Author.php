<?php

namespace App\Domain\Entity;

class Author
{
    private int $id;
    private string $name;
    private array $books = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getBooks(): array
    {
        return $this->books;
    }

    public function addBook(Book $book): void
    {
        $this->books[] = $book;
    }

    public function removeBook(Book $book): void
    {
        $key = array_search($book, $this->books, true);
        if ($key !== false) {
            unset($this->books[$key]);
        }
    }
}
