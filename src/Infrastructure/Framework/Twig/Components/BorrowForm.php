<?php

namespace App\Infrastructure\Framework\Twig\Components;

use App\Domain\Entity\BorrowRecord;
use App\Infrastructure\Framework\Form\BorrowType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\ValidatableComponentTrait;

#[AsLiveComponent('borrow_form')]
class BorrowForm extends AbstractController
{
    use ComponentWithFormTrait;
    use ValidatableComponentTrait;
    use DefaultActionTrait;

    public ?BorrowRecord $borrowRecord = null;

    #[LiveProp]
    public ?string $submitLabel = null;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(BorrowType::class, $this->borrowRecord);
    }
}
