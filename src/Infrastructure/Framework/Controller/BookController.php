<?php

namespace App\Infrastructure\Framework\Controller;

use App\Application\UseCase\BookUseCase;
use App\Domain\Entity\Book;
use App\Infrastructure\Framework\Form\BookType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BookController extends AbstractController
{
    private BookUseCase $bookUseCase;

    public function __construct(BookUseCase $bookUseCase)
    {
        $this->bookUseCase = $bookUseCase;
    }

    #[Route('/books/create', name: 'create_book', methods: ['GET', 'POST'])]
    public function createBook(Request $request): Response
    {
        $form = $this->createForm(BookType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookData = $form->getData();
            $this->bookUseCase->createBook($bookData->getTitle(), $bookData->getIsbn(), $bookData->getAuthor()->getId());
            $this->addFlash('success', 'Book created successfully');
            return $this->redirectToRoute('app_book_index');
        }

        return $this->render('book/new.html.twig', [
            'form' => $form->createView(),
            'book' => $form->getData()
        ]);
    }

    #[Route('/books/{id}/update', name: 'update_book', methods: ['GET', 'POST'])]
    public function updateBook(int $id, Request $request): Response
    {
        $book = $this->bookUseCase->getBook($id);
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->bookUseCase->updateBook($id, $book->getTitle(), $book->getIsbn(), $book->getAuthor()->getId());
            $this->addFlash('success', 'Book updated successfully');
            return $this->redirectToRoute('app_book_index');
        }

        return $this->render('book/edit.html.twig', [
            'form' => $form->createView(),
            'book' => $book,
        ]);
    }

    #[Route('/books/{id}/delete', name: 'delete_book', methods: ['DELETE'])]
    public function deleteBook(int $id): JsonResponse
    {
        $this->bookUseCase->deleteBook($id);
        return $this->json(['message' => 'Book deleted successfully']);
    }

    #[Route('/books/{id}', name: 'get_book', methods: ['GET'])]
    public function getBook(int $id): Response
    {
        $book = $this->bookUseCase->getBook($id);
        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }

    #[Route('/books', name: 'app_book_index', methods: ['GET'])]
    public function index(): Response
    {
        $books = $this->bookUseCase->getAllBooks();
        return $this->render('book/index.html.twig', [
            'books' => $books,
        ]);
    }
}
