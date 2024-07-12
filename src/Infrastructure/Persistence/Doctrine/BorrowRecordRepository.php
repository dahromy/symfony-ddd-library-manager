<?php

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Entity\BorrowRecord;
use App\Domain\Repository\BorrowRecordRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class BorrowRecordRepository extends ServiceEntityRepository implements BorrowRecordRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BorrowRecordEntity::class);
    }

    public function findById(int $id): ?BorrowRecord
    {
        $borrowRecordEntity = $this->find($id);
        return $borrowRecordEntity ? $borrowRecordEntity->toDomainEntity() : null;
    }

    public function findAll(): array
    {
        return array_map(
            fn(BorrowRecordEntity $borrowRecordEntity) => $borrowRecordEntity->toDomainEntity(),
            $this->findBy([])
        );
    }

    public function save(BorrowRecord $borrowRecord): void
    {
        $borrowRecordEntity = new BorrowRecordEntity($borrowRecord);
        $this->getEntityManager()->persist($borrowRecordEntity);
        $this->getEntityManager()->flush();
    }

    public function delete(BorrowRecord $borrowRecord): void
    {
        $this->getEntityManager()->remove($borrowRecord);
        $this->getEntityManager()->flush();
    }
}
