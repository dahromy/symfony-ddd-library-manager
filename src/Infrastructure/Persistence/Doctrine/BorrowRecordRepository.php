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
        parent::__construct($registry, BorrowRecord::class);
    }

    public function findById(int $id): ?BorrowRecord
    {
        return $this->find($id);
    }

    public function findAll(): array
    {
        return $this->findBy([]);
    }

    public function save(BorrowRecord $borrowRecord): void
    {
        $this->getEntityManager()->persist($borrowRecord);
        $this->getEntityManager()->flush();
    }

    public function delete(BorrowRecord $borrowRecord): void
    {
        $this->getEntityManager()->remove($borrowRecord);
        $this->getEntityManager()->flush();
    }
}
