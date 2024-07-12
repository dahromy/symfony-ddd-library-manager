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

    public function __construct(Author $author)
    {
        $this->name = $author->getName();
        $this->books = new ArrayCollection();
    }

    public function toDomainEntity(): Author
    {
        $author = new Author($this->name);
        // We need to set the ID manually as it's not part of the constructor
        $reflection = new \ReflectionClass($author);
        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($author, $this->id);
        
        return $author;
    }
}
