<?php

namespace App\Application\UseCase;

use App\Domain\Entity\Book;
use App\Domain\Repository\BookRepositoryInterface;
use App\Domain\Repository\AuthorRepositoryInterface;

readonly class BookUseCase
{

    public function __construct(private BookRepositoryInterface $bookRepository, private AuthorRepositoryInterface $authorRepository)
    {
    }

    public function createBook(string $title, string $isbn, int $authorId): Book
    {
        if (empty(trim($title))) {
            throw new \InvalidArgumentException("Book title cannot be empty");
        }

        if (empty(trim($isbn))) {
            throw new \InvalidArgumentException("ISBN cannot be empty");
        }

        $author = $this->authorRepository->findById($authorId);

        if (!$author) {
            throw new \RuntimeException("Author not found");
        }

        $book = new Book($title, $isbn, $author);
        $this->bookRepository->save($book);

        return $book;
    }

    /**
     * @throws \Exception
     */
    public function updateBook(int $id, string $title, string $isbn, int $authorId): Book
    {
        $book = $this->bookRepository->findById($id);

        if (!$book) {
            throw new \Exception("Book not found");
        }

        $author = $this->authorRepository->findById($authorId);
        if (!$author) {
            throw new \Exception("Author not found");
        }

        $book->setTitle($title);
        $book->setIsbn($isbn);
        $book->setAuthor($author);

        $this->bookRepository->save($book);

        return $book;
    }

    /**
     * @throws \Exception
     */
    public function deleteBook(int $id): void
    {
        $book = $this->bookRepository->findById($id);

        if (!$book) {
            throw new \Exception("Book not found");
        }

        $this->bookRepository->delete($book);
    }

    /**
     * @throws \Exception
     */
    public function getBook(int $id): Book
    {
        $book = $this->bookRepository->findById($id);

        if (!$book) {
            throw new \Exception("Book not found");
        }

        return $book;
    }

    public function getAllBooks(): array
    {
        return $this->bookRepository->findAll();
    }
}
