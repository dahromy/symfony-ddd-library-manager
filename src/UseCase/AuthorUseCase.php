<?php

namespace App\UseCase;

use App\Entity\Author;
use App\Repository\AuthorRepositoryInterface;

class AuthorUseCase
{
    private AuthorRepositoryInterface $authorRepository;

    public function __construct(AuthorRepositoryInterface $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    public function createAuthor(string $name): Author
    {
        $author = new Author($name);
        $this->authorRepository->save($author);
        return $author;
    }

    public function updateAuthor(int $id, string $name): Author
    {
        $author = $this->authorRepository->findById($id);
        if (!$author) {
            throw new \Exception("Author not found");
        }

        $author->setName($name);
        $this->authorRepository->save($author);
        return $author;
    }

    public function deleteAuthor(int $id): void
    {
        $author = $this->authorRepository->findById($id);
        if (!$author) {
            throw new \Exception("Author not found");
        }

        $this->authorRepository->delete($author);
    }

    public function getAuthor(int $id): Author
    {
        $author = $this->authorRepository->findById($id);
        if (!$author) {
            throw new \Exception("Author not found");
        }

        return $author;
    }

    public function getAllAuthors(): array
    {
        return $this->authorRepository->findAll();
    }
}