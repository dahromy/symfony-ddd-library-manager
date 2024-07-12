<?php

namespace App\Repository;

use App\Entity\BorrowRecord;

interface BorrowRecordRepositoryInterface
{
    public function findById(int $id): ?BorrowRecord;
    public function findAll(): array;
    public function save(BorrowRecord $borrowRecord): void;
    public function delete(BorrowRecord $borrowRecord): void;
}
