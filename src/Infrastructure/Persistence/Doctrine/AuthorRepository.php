<?php

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Entity\Author;
use App\Domain\Repository\AuthorRepositoryInterface;
use App\Infrastructure\Persistence\Doctrine\Entity\AuthorEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AuthorRepository extends ServiceEntityRepository implements AuthorRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AuthorEntity::class);
    }

    public function findById(int $id): ?Author
    {
        $authorEntity = $this->find($id);
        return $authorEntity ? $authorEntity->toDomainEntity() : null;
    }

    public function findAll(): array
    {
        return array_map(
            fn(AuthorEntity $authorEntity) => $authorEntity->toDomainEntity(),
            $this->findBy([])
        );
    }

    public function save(Author $author): void
    {
        $authorEntity = $this->getEntityManager()->find(AuthorEntity::class, $author->getId()) 
            ?? AuthorEntity::fromDomainEntity($author);
        
        $authorEntity->setName($author->getName());
        
        $this->getEntityManager()->persist($authorEntity);
        $this->getEntityManager()->flush();
    }

    public function delete(Author $author): void
    {
        $authorEntity = $this->getEntityManager()->find(AuthorEntity::class, $author->getId());
        if ($authorEntity) {
            $this->getEntityManager()->remove($authorEntity);
            $this->getEntityManager()->flush();
        }
    }
}
