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

    public function __construct(BookEntity $book, string $borrowerName, DateTime $borrowDate)
    {
        $this->book = $book;
        $this->borrowerName = $borrowerName;
        $this->borrowDate = $borrowDate;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBook(): BookEntity
    {
        return $this->book;
    }

    public function getBorrowerName(): string
    {
        return $this->borrowerName;
    }

    public function getBorrowDate(): DateTime
    {
        return $this->borrowDate;
    }

    public function getReturnDate(): ?DateTime
    {
        return $this->returnDate;
    }

    public function setReturnDate(DateTime $returnDate): void
    {
        $this->returnDate = $returnDate;
    }

    public function toDomainEntity(): BorrowRecord
    {
        $borrowRecord = new BorrowRecord($this->book->toDomainEntity(), $this->borrowerName, $this->borrowDate);
        $reflection = new \ReflectionClass($borrowRecord);
        $idProperty = $reflection->getProperty('id');
        $idProperty->setAccessible(true);
        $idProperty->setValue($borrowRecord, $this->id);
        
        if ($this->returnDate) {
            $borrowRecord->setReturnDate($this->returnDate);
        }
        
        return $borrowRecord;
    }

    public static function fromDomainEntity(BorrowRecord $borrowRecord): self
    {
        $bookEntity = BookEntity::fromDomainEntity($borrowRecord->getBook());
        $borrowRecordEntity = new self($bookEntity, $borrowRecord->getBorrowerName(), $borrowRecord->getBorrowDate());
        if ($borrowRecord->getId() !== null) {
            $reflection = new \ReflectionClass($borrowRecordEntity);
            $property = $reflection->getProperty('id');
            $property->setAccessible(true);
            $property->setValue($borrowRecordEntity, $borrowRecord->getId());
        }
        if ($borrowRecord->getReturnDate() !== null) {
            $borrowRecordEntity->setReturnDate($borrowRecord->getReturnDate());
        }
        return $borrowRecordEntity;
    }
}
