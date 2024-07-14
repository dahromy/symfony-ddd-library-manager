<?php

namespace App\Domain\Entity;

use DateTime;

class BorrowRecord
{
    private ?int $id = null;
    private ?DateTime $returnDate = null;

    public function __construct(
        private readonly Book      $book,
        private readonly string    $borrowerName,
        private readonly ?DateTime $borrowDate = null
    )
    {
    }

    public function getId(): ?int
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
