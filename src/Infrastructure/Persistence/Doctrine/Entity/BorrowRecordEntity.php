<?php

namespace App\Infrastructure\Persistence\Doctrine\Entity;

use App\Domain\Entity\BorrowRecord;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'borrow_records')]
class BorrowRecordEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: BookEntity::class)]
    #[ORM\JoinColumn(nullable: false)]
    private BookEntity $book;

    #[ORM\Column(type: 'string', length: 255)]
    private string $borrowerName;

    #[ORM\Column(type: 'datetime')]
    private DateTime $borrowDate;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?DateTime $returnDate = null;

    public function __construct(BorrowRecord $borrowRecord)
    {
        $this->borrowerName = $borrowRecord->getBorrowerName();
        $this->borrowDate = $borrowRecord->getBorrowDate();
        $this->returnDate = $borrowRecord->getReturnDate();
        // Note: We'll need to handle the book separately
    }

    public function toDomainEntity(): BorrowRecord
    {
        $borrowRecord = new BorrowRecord($this->book->toDomainEntity(), $this->borrowerName, $this->borrowDate);
        // We need to set the ID and return date manually as they're not part of the constructor
        $reflection = new \ReflectionClass($borrowRecord);
        $idProperty = $reflection->getProperty('id');
        $idProperty->setAccessible(true);
        $idProperty->setValue($borrowRecord, $this->id);
        
        if ($this->returnDate) {
            $borrowRecord->setReturnDate($this->returnDate);
        }
        
        return $borrowRecord;
    }
}
