<?php

namespace App\Repository;

use App\Entity\Author;

interface AuthorRepositoryInterface
{
    public function findById(int $id): ?Author;
    public function findAll(): array;
    public function save(Author $author): void;
    public function delete(Author $author): void;
}
