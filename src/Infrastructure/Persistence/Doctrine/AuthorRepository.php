<?php

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Entity\Author;
use App\Domain\Repository\AuthorRepositoryInterface;
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
        $authorEntity = new AuthorEntity($author);
        $this->getEntityManager()->persist($authorEntity);
        $this->getEntityManager()->flush();
    }

    public function delete(Author $author): void
    {
        $this->getEntityManager()->remove($author);
        $this->getEntityManager()->flush();
    }
}
