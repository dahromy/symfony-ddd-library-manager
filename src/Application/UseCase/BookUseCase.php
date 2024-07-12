<?php

namespace App\Application\UseCase;

use App\Domain\Entity\Book;
use App\Domain\Repository\BookRepositoryInterface;
use App\Domain\Repository\AuthorRepositoryInterface;

class BookUseCase
{
    private BookRepositoryInterface $bookRepository;
    private AuthorRepositoryInterface $authorRepository;

    public function __construct(BookRepositoryInterface $bookRepository, AuthorRepositoryInterface $authorRepository)
    {
        $this->bookRepository = $bookRepository;
        $this->authorRepository = $authorRepository;
    }

    public function createBook(string $title, string $isbn, int $authorId): Book
    {
        $author = $this->authorRepository->findById($authorId);
        if (!$author) {
            throw new \Exception("Author not found");
        }

        $book = new Book($title, $isbn, $author);
        $this->bookRepository->save($book);
        return $book;
    }

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

    public function deleteBook(int $id): void
    {
        $book = $this->bookRepository->findById($id);
        if (!$book) {
            throw new \Exception("Book not found");
        }

        $this->bookRepository->delete($book);
    }

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
