<?php

namespace App\Application\UseCase;

use App\Domain\Entity\BorrowRecord;
use App\Domain\Repository\BorrowRecordRepositoryInterface;
use App\Domain\Repository\BookRepositoryInterface;
use DateTime;

class BorrowUseCase
{
    private BorrowRecordRepositoryInterface $borrowRecordRepository;
    private BookRepositoryInterface $bookRepository;

    public function __construct(BorrowRecordRepositoryInterface $borrowRecordRepository, BookRepositoryInterface $bookRepository)
    {
        $this->borrowRecordRepository = $borrowRecordRepository;
        $this->bookRepository = $bookRepository;
    }

    public function borrowBook(int $bookId, string $borrowerName): BorrowRecord
    {
        $book = $this->bookRepository->findById($bookId);
        if (!$book) {
            throw new \Exception("Book not found");
        }

        $borrowRecord = new BorrowRecord($book, $borrowerName, new DateTime());
        $this->borrowRecordRepository->save($borrowRecord);
        return $borrowRecord;
    }

    public function returnBook(int $borrowRecordId): BorrowRecord
    {
        $borrowRecord = $this->borrowRecordRepository->findById($borrowRecordId);
        if (!$borrowRecord) {
            throw new \Exception("Borrow record not found");
        }

        if ($borrowRecord->getReturnDate() !== null) {
            throw new \Exception("Book already returned");
        }

        $borrowRecord->setReturnDate(new DateTime());
        $this->borrowRecordRepository->save($borrowRecord);
        return $borrowRecord;
    }

    public function getBorrowRecord(int $id): BorrowRecord
    {
        $borrowRecord = $this->borrowRecordRepository->findById($id);
        if (!$borrowRecord) {
            throw new \Exception("Borrow record not found");
        }

        return $borrowRecord;
    }

    public function getAllBorrowRecords(): array
    {
        return $this->borrowRecordRepository->findAll();
    }
}