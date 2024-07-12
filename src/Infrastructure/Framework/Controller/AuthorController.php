<?php

namespace App\Infrastructure\Framework\Controller;

use App\Application\UseCase\AuthorUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    private AuthorUseCase $authorUseCase;

    public function __construct(AuthorUseCase $authorUseCase)
    {
        $this->authorUseCase = $authorUseCase;
    }

    #[Route('/authors', name: 'create_author', methods: ['POST'])]
    public function createAuthor(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $author = $this->authorUseCase->createAuthor($data['name']);
        return $this->json($author);
    }

    #[Route('/authors/{id}', name: 'update_author', methods: ['PUT'])]
    public function updateAuthor(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $author = $this->authorUseCase->updateAuthor($id, $data['name']);
        return $this->json($author);
    }

    #[Route('/authors/{id}', name: 'delete_author', methods: ['DELETE'])]
    public function deleteAuthor(int $id): JsonResponse
    {
        $this->authorUseCase->deleteAuthor($id);
        return $this->json(['message' => 'Author deleted successfully']);
    }

    #[Route('/authors/{id}', name: 'get_author', methods: ['GET'])]
    public function getAuthor(int $id): JsonResponse
    {
        $author = $this->authorUseCase->getAuthor($id);
        return $this->json($author);
    }

    #[Route('/authors', name: 'get_all_authors', methods: ['GET'])]
    public function getAllAuthors(): JsonResponse
    {
        $authors = $this->authorUseCase->getAllAuthors();
        return $this->json($authors);
    }
}
