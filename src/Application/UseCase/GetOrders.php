<?php

namespace App\Application\UseCase;

use App\Domain\Repository\OrderRepositoryInterface;

class GetOrders
{
    private OrderRepositoryInterface $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function execute(): array
    {
        return $this->orderRepository->findAll();
    }
}
