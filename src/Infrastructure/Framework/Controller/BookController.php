<?php

namespace App\Infrastructure\Framework\Controller;

use App\Application\UseCase\BookUseCase;
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
            $data = $form->getData();

            $book = $this->bookUseCase->createBook($data['title'], $data['isbn'], $data['author']->getId());
            $this->addFlash('success', 'Book created successfully');
            return $this->redirectToRoute('get_all_books');
        }

        return $this->render('book/new.html.twig', [
            'form' => $form->createView(),
            'book' => null,
        ]);
    }

    #[Route('/books/{id}/update', name: 'update_book', methods: ['GET', 'POST'])]
    public function updateBook(int $id, Request $request): Response
    {
        $book = $this->bookUseCase->getBook($id);

        $form = $this->createForm(BookType::class, [
            'title' => $book->getTitle(),
            'isbn' => $book->getIsbn(),
            'author' => $book->getAuthor()
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $this->bookUseCase->updateBook($id, $data['title'], $data['isbn'], $data['author']->getId());
            $this->addFlash('success', 'Book updated successfully');
            return $this->redirectToRoute('get_all_books');
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

    #[Route('/books', name: 'get_all_books', methods: ['GET'])]
    public function getAllBooks(): Response
    {
        $books = $this->bookUseCase->getAllBooks();
        return $this->render('book/index.html.twig', [
            'books' => $books,
        ]);
    }
}
