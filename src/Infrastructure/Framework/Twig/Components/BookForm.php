<?php

namespace App\Infrastructure\Framework\Twig\Components;

use App\Domain\Entity\Book;
use App\Infrastructure\Framework\Form\BookType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('book_form')]
class BookForm extends AbstractController
{
    use ComponentWithFormTrait;
    use DefaultActionTrait;

    public ?Book $book = null;

    #[LiveProp]
    public ?string $submitLabel = null;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(BookType::class, $this->book);
    }
}
