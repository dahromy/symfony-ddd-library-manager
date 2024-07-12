<?php

namespace App\Domain\Entity;

class Order
{
    private int $id;
    private string $customerName;
    private string $address;
    private array $items;
    private \DateTimeImmutable $createdAt;
    private string $status;

    public function __construct(string $customerName, string $address, array $items)
    {
        $this->customerName = $customerName;
        $this->address = $address;
        $this->items = $items;
        $this->createdAt = new \DateTimeImmutable();
        $this->status = 'pending';
    }

    // Getters and setters...

    public function getId(): int
    {
        return $this->id;
    }

    public function getCustomerName(): string
    {
        return $this->customerName;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}
