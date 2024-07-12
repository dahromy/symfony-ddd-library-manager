<?php

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Entity\Book;
use App\Domain\Repository\BookRepositoryInterface;
use App\Infrastructure\Persistence\Doctrine\Entity\BookEntity;
use App\Infrastructure\Persistence\Doctrine\Entity\AuthorEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class BookRepository extends ServiceEntityRepository implements BookRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookEntity::class);
    }

    public function findById(int $id): ?Book
    {
        $bookEntity = $this->find($id);
        return $bookEntity ? $bookEntity->toDomainEntity() : null;
    }

    public function findAll(): array
    {
        return array_map(
            fn(BookEntity $bookEntity) => $bookEntity->toDomainEntity(),
            $this->findBy([])
        );
    }

    public function save(Book $book): void
    {
        $bookEntity = $this->getEntityManager()->find(BookEntity::class, $book->getId()) 
            ?? BookEntity::fromDomainEntity($book);
        
        $bookEntity->setTitle($book->getTitle());
        $bookEntity->setIsbn($book->getIsbn());
        
        $authorEntity = $this->getEntityManager()->find(AuthorEntity::class, $book->getAuthor()->getId()) 
            ?? AuthorEntity::fromDomainEntity($book->getAuthor());
        $bookEntity->setAuthor($authorEntity);
        
        $this->getEntityManager()->persist($bookEntity);
        $this->getEntityManager()->flush();
    }

    public function delete(Book $book): void
    {
        $bookEntity = $this->getEntityManager()->find(BookEntity::class, $book->getId());
        if ($bookEntity) {
            $this->getEntityManager()->remove($bookEntity);
            $this->getEntityManager()->flush();
        }
    }
}
