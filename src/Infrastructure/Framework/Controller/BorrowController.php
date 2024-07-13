<?php

namespace App\Infrastructure\Framework\Controller;

use App\Application\UseCase\BorrowUseCase;
use App\Domain\Repository\BookRepositoryInterface;
use App\Infrastructure\Framework\Form\BorrowType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/borrow')]
class BorrowController extends AbstractController
{
    public function __construct(
        private BorrowUseCase $borrowUseCase,
        private BookRepositoryInterface $bookRepository
    ) {
    }

    #[Route('/', name: 'app_borrow_index', methods: ['GET'])]
    public function index(): Response
    {
        $borrowRecords = $this->borrowUseCase->getAllBorrowRecords();
        return $this->render('borrow/index.html.twig', [
            'borrow_records' => $borrowRecords,
        ]);
    }

    #[Route('/new', name: 'app_borrow_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $form = $this->createForm(BorrowType::class, null, [
            'book_repository' => $this->bookRepository,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $borrowRecord = $form->getData();
            $this->borrowUseCase->borrowBook($borrowRecord->getBook()->getId(), $borrowRecord->getBorrowerName());
            $this->addFlash('success', 'Book borrowed successfully.');
            return $this->redirectToRoute('app_borrow_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('borrow/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_borrow_show', methods: ['GET'])]
    public function show(int $id): Response
    {
        $borrowRecord = $this->borrowUseCase->getBorrowRecord($id);
        return $this->render('borrow/show.html.twig', [
            'borrow_record' => $borrowRecord,
        ]);
    }

    #[Route('/{id}/return', name: 'app_borrow_return', methods: ['POST'])]
    public function returnBook(Request $request, int $id): Response
    {
        if ($this->isCsrfTokenValid('return'.$id, $request->request->get('_token'))) {
            $this->borrowUseCase->returnBook($id);
        }

        return $this->redirectToRoute('app_borrow_index', [], Response::HTTP_SEE_OTHER);
    }
}
