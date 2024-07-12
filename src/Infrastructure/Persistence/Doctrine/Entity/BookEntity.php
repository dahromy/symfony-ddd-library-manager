<?php

namespace App\Infrastructure\Persistence\Doctrine\Entity;

use App\Domain\Entity\Book;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'books')]
class BookEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $title;

    #[ORM\Column(type: 'string', length: 13, unique: true)]
    private string $isbn;

    #[ORM\ManyToOne(targetEntity: AuthorEntity::class, inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: false)]
    private AuthorEntity $author;

    public function __construct(string $title, string $isbn, AuthorEntity $author)
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

    public function getAuthor(): AuthorEntity
    {
        return $this->author;
    }

    public function setAuthor(AuthorEntity $author): void
    {
        $this->author = $author;
    }

    public function toDomainEntity(): Book
    {
        $book = new Book($this->title, $this->isbn, $this->author->toDomainEntity());
        $reflection = new \ReflectionClass($book);
        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($book, $this->id);
        
        return $book;
    }

    public static function fromDomainEntity(Book $book): self
    {
        $authorEntity = AuthorEntity::fromDomainEntity($book->getAuthor());
        $bookEntity = new self($book->getTitle(), $book->getIsbn(), $authorEntity);
        if ($book->getId() !== null) {
            $reflection = new \ReflectionClass($bookEntity);
            $property = $reflection->getProperty('id');
            $property->setAccessible(true);
            $property->setValue($bookEntity, $book->getId());
        }
        return $bookEntity;
    }
}
