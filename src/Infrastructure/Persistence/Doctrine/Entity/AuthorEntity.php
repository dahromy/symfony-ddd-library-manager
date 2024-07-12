<?php

namespace App\Infrastructure\Persistence\Doctrine\Entity;

use App\Domain\Entity\Author;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'authors')]
class AuthorEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\OneToMany(targetEntity: BookEntity::class, mappedBy: 'author')]
    private Collection $books;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->books = new ArrayCollection();
    }

    public function getId(): ?int
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

    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(BookEntity $book): self
    {
        if (!$this->books->contains($book)) {
            $this->books[] = $book;
            $book->setAuthor($this);
        }

        return $this;
    }

    public function removeBook(BookEntity $book): self
    {
        if ($this->books->removeElement($book)) {
            if ($book->getAuthor() === $this) {
                $book->setAuthor(null);
            }
        }

        return $this;
    }

    public function toDomainEntity(): Author
    {
        $author = new Author($this->name);
        $reflection = new \ReflectionClass($author);
        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($author, $this->id);
        
        foreach ($this->books as $bookEntity) {
            $author->addBook($bookEntity->toDomainEntity());
        }
        
        return $author;
    }

    public static function fromDomainEntity(Author $author): self
    {
        $authorEntity = new self($author->getName());
        if ($author->getId() !== null) {
            $reflection = new \ReflectionClass($authorEntity);
            $property = $reflection->getProperty('id');
            $property->setAccessible(true);
            $property->setValue($authorEntity, $author->getId());
        }
        return $authorEntity;
    }
}
