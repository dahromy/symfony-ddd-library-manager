<?php

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'books')]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $title;

    #[ORM\Column(type: 'string', length: 13, unique: true)]
    private string $isbn;

    #[ORM\ManyToOne(targetEntity: Author::class, inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: false)]
    private Author $author;

    public function __construct(string $title, string $isbn, Author $author)
    {
        $this->title = $title;
        $this->isbn = $isbn;
        $this->author = $author;
    }

    public function getId(): int
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
