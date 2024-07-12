<?php

namespace App\Application\UseCase;

use App\Domain\Entity\Order;
use App\Domain\Repository\OrderRepositoryInterface;

class CreateOrder
{
    private OrderRepositoryInterface $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function execute(string $customerName, string $address, array $items): Order
    {
        $order = new Order($customerName, $address, $items);
        $this->orderRepository->save($order);
        return $order;
    }
}
