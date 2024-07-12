<?php

namespace App\Infrastructure\Framework\Controller;

use App\Application\UseCase\BorrowUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BorrowController extends AbstractController
{
    private BorrowUseCase $borrowUseCase;

    public function __construct(BorrowUseCase $borrowUseCase)
    {
        $this->borrowUseCase = $borrowUseCase;
    }

    #[Route('/borrow', name: 'borrow_book', methods: ['POST'])]
    public function borrowBook(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $borrowRecord = $this->borrowUseCase->borrowBook($data['bookId'], $data['borrowerName']);
        return $this->json($borrowRecord);
    }

    #[Route('/return/{id}', name: 'return_book', methods: ['POST'])]
    public function returnBook(int $id): JsonResponse
    {
        $borrowRecord = $this->borrowUseCase->returnBook($id);
        return $this->json($borrowRecord);
    }

    #[Route('/borrow/{id}', name: 'get_borrow_record', methods: ['GET'])]
    public function getBorrowRecord(int $id): JsonResponse
    {
        $borrowRecord = $this->borrowUseCase->getBorrowRecord($id);
        return $this->json($borrowRecord);
    }

    #[Route('/borrow', name: 'get_all_borrow_records', methods: ['GET'])]
    public function getAllBorrowRecords(): JsonResponse
    {
        $borrowRecords = $this->borrowUseCase->getAllBorrowRecords();
        return $this->json($borrowRecords);
    }
}
