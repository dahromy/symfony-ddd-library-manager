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

    public function __construct(Book $book)
    {
        $this->title = $book->getTitle();
        $this->isbn = $book->getIsbn();
        // Note: We'll need to handle the author separately
    }

    public function toDomainEntity(): Book
    {
        $book = new Book($this->title, $this->isbn, $this->author->toDomainEntity());
        // We need to set the ID manually as it's not part of the constructor
        $reflection = new \ReflectionClass($book);
        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($book, $this->id);
        
        return $book;
    }
}
