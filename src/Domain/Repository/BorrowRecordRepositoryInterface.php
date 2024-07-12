<?php

namespace App\Domain\Repository;

use App\Domain\Entity\BorrowRecord;

interface BorrowRecordRepositoryInterface
{
    public function findById(int $id): ?BorrowRecord;
    public function findAll(): array;
    public function save(BorrowRecord $borrowRecord): void;
    public function delete(BorrowRecord $borrowRecord): void;
}
