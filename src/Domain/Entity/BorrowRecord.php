<?php

namespace App\Domain\Entity;

use DateTime;

class BorrowRecord
{
    private ?int $id = null;
    private Book $book;
    private string $borrowerName;
    private DateTime $borrowDate;
    private ?DateTime $returnDate = null;

    public function __construct(Book $book, string $borrowerName, DateTime $borrowDate)
    {
        $this->book = $book;
        $this->borrowerName = $borrowerName;
        $this->borrowDate = $borrowDate;
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
