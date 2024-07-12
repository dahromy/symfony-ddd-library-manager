<?php

namespace App\Domain\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'borrow_records')]
class BorrowRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Book::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Book $book;

    #[ORM\Column(type: 'string', length: 255)]
    private string $borrowerName;

    #[ORM\Column(type: 'datetime')]
    private DateTime $borrowDate;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?DateTime $returnDate = null;

    public function __construct(Book $book, string $borrowerName, DateTime $borrowDate)
    {
        $this->book = $book;
        $this->borrowerName = $borrowerName;
        $this->borrowDate = $borrowDate;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getBook(): Book
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
}
