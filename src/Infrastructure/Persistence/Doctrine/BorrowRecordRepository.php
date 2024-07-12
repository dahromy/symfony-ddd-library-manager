<?php

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Entity\BorrowRecord;
use App\Domain\Repository\BorrowRecordRepositoryInterface;
use App\Infrastructure\Persistence\Doctrine\Entity\BorrowRecordEntity;
use App\Infrastructure\Persistence\Doctrine\Entity\BookEntity;
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
        $borrowRecordEntity = $this->getEntityManager()->find(BorrowRecordEntity::class, $borrowRecord->getId()) 
            ?? BorrowRecordEntity::fromDomainEntity($borrowRecord);
        
        $bookEntity = $this->getEntityManager()->find(BookEntity::class, $borrowRecord->getBook()->getId()) 
            ?? BookEntity::fromDomainEntity($borrowRecord->getBook());
        $borrowRecordEntity->setBook($bookEntity);
        
        $borrowRecordEntity->setBorrowerName($borrowRecord->getBorrowerName());
        $borrowRecordEntity->setBorrowDate($borrowRecord->getBorrowDate());
        $borrowRecordEntity->setReturnDate($borrowRecord->getReturnDate());
        
        $this->getEntityManager()->persist($borrowRecordEntity);
        $this->getEntityManager()->flush();
    }

    public function delete(BorrowRecord $borrowRecord): void
    {
        $borrowRecordEntity = $this->getEntityManager()->find(BorrowRecordEntity::class, $borrowRecord->getId());
        if ($borrowRecordEntity) {
            $this->getEntityManager()->remove($borrowRecordEntity);
            $this->getEntityManager()->flush();
        }
    }
}
