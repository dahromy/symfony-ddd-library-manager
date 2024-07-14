<?php

namespace App\Application\UseCase;

use App\Domain\Entity\Author;
use App\Domain\Repository\AuthorRepositoryInterface;

readonly class AuthorUseCase
{
    public function __construct(private AuthorRepositoryInterface $authorRepository)
    {
    }

    public function createAuthor(string $name): Author
    {
        if (empty(trim($name))) {
            throw new \InvalidArgumentException("Author name cannot be empty");
        }

        $author = new Author($name);
        $this->authorRepository->save($author);

        return $author;
    }

    public function updateAuthor(int $id, string $name): Author
    {
        $author = $this->authorRepository->findById($id);

        if (!$author) {
            throw new \RuntimeException("Author not found");
        }

        if (empty(trim($name))) {
            throw new \InvalidArgumentException("Author name cannot be empty");
        }

        $author->setName($name);
        $this->authorRepository->save($author);

        return $author;
    }

    /**
     * @throws \Exception
     */
    public function deleteAuthor(int $id): void
    {
        $author = $this->authorRepository->findById($id);

        if (!$author) {
            throw new \Exception("Author not found");
        }

        $this->authorRepository->delete($author);
    }

    /**
     * @throws \Exception
     */
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
