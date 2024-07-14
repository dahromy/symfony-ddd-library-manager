<?php

namespace App\Application\UseCase;

use App\Domain\Entity\BorrowRecord;
use App\Domain\Repository\BorrowRecordRepositoryInterface;
use App\Domain\Repository\BookRepositoryInterface;
use DateTime;

readonly class BorrowUseCase
{

    public function __construct(private BorrowRecordRepositoryInterface $borrowRecordRepository, private BookRepositoryInterface $bookRepository)
    {
    }

    public function borrowBook(int $bookId, string $borrowerName): BorrowRecord
    {
        $book = $this->bookRepository->findById($bookId);

        if (!$book) {
            throw new \RuntimeException("Book not found");
        }

        if (empty(trim($borrowerName))) {
            throw new \InvalidArgumentException("Borrower name cannot be empty");
        }

        $borrowRecord = new BorrowRecord($book, $borrowerName, new DateTime());
        $this->borrowRecordRepository->save($borrowRecord);

        return $borrowRecord;
    }

    /**
     * @throws \Exception
     */
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

    /**
     * @throws \Exception
     */
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
