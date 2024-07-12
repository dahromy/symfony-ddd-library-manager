<?php

namespace App\Domain\Entity;

class Book
{
    private ?int $id = null;
    private string $title;
    private string $isbn;
    private Author $author;

    public function __construct(string $title, string $isbn, Author $author)
    {
        $this->title = $title;
        $this->isbn = $isbn;
        $this->author = $author;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getIsbn(): string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): void
    {
        $this->isbn = $isbn;
    }

    public function getAuthor(): Author
    {
        return $this->author;
    }

    public function setAuthor(Author $author): void
    {
        $this->author = $author;
    }
}
