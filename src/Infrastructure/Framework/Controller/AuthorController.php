<?php

namespace App\Infrastructure\Framework\Controller;

use App\Application\UseCase\AuthorUseCase;
use App\Infrastructure\Framework\Form\AuthorType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/author')]
class AuthorController extends AbstractController
{
    private AuthorUseCase $authorUseCase;

    public function __construct(AuthorUseCase $authorUseCase)
    {
        $this->authorUseCase = $authorUseCase;
    }

    #[Route('/', name: 'app_author_index', methods: ['GET'])]
    public function index(): Response
    {
        $authors = $this->authorUseCase->getAllAuthors();
        return $this->render('author/index.html.twig', [
            'authors' => $authors,
        ]);
    }

    #[Route('/new', name: 'app_author_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $form = $this->createForm(AuthorType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $author = $this->authorUseCase->createAuthor($form->get('name')->getData());
            return $this->redirectToRoute('app_author_show', ['id' => $author->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('author/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_author_show', methods: ['GET'])]
    public function show(int $id): Response
    {
        $author = $this->authorUseCase->getAuthor($id);
        return $this->render('author/show.html.twig', [
            'author' => $author,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_author_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, int $id): Response
    {
        $author = $this->authorUseCase->getAuthor($id);
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->authorUseCase->updateAuthor($id, $form->get('name')->getData());
            return $this->redirectToRoute('app_author_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('author/edit.html.twig', [
            'author' => $author,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_author_delete', methods: ['POST'])]
    public function delete(Request $request, int $id): Response
    {
        if ($this->isCsrfTokenValid('delete'.$id, $request->request->get('_token'))) {
            $this->authorUseCase->deleteAuthor($id);
        }

        return $this->redirectToRoute('app_author_index', [], Response::HTTP_SEE_OTHER);
    }
}
