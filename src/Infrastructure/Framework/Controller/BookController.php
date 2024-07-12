<?php

namespace App\Infrastructure\Framework\Controller;

use App\Application\UseCase\BookUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class BookController extends AbstractController
{
    private BookUseCase $bookUseCase;

    public function __construct(BookUseCase $bookUseCase)
    {
        $this->bookUseCase = $bookUseCase;
    }

    #[Route('/books', name: 'create_book', methods: ['POST'])]
    public function createBook(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $book = $this->bookUseCase->createBook($data['title'], $data['isbn'], $data['authorId']);
        return $this->json($book);
    }

    #[Route('/books/{id}', name: 'update_book', methods: ['PUT'])]
    public function updateBook(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $book = $this->bookUseCase->updateBook($id, $data['title'], $data['isbn'], $data['authorId']);
        return $this->json($book);
    }

    #[Route('/books/{id}', name: 'delete_book', methods: ['DELETE'])]
    public function deleteBook(int $id): JsonResponse
    {
        $this->bookUseCase->deleteBook($id);
        return $this->json(['message' => 'Book deleted successfully']);
    }

    #[Route('/books/{id}', name: 'get_book', methods: ['GET'])]
    public function getBook(int $id): JsonResponse
    {
        $book = $this->bookUseCase->getBook($id);
        return $this->json($book);
    }

    #[Route('/books', name: 'get_all_books', methods: ['GET'])]
    public function getAllBooks(): JsonResponse
    {
        $books = $this->bookUseCase->getAllBooks();
        return $this->json($books);
    }
}
