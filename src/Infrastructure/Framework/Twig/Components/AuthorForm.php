<?php

namespace App\Infrastructure\Framework\Twig\Components;

use App\Domain\Entity\Author;
use App\Infrastructure\Framework\Form\AuthorType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\ValidatableComponentTrait;

#[AsLiveComponent('author_form')]
class AuthorForm extends AbstractController
{
    use ComponentWithFormTrait;
    use ValidatableComponentTrait;
    use DefaultActionTrait;

    public ?Author $author = null;

    #[LiveProp]
    public ?string $submitLabel = null;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(AuthorType::class, $this->author);
    }
}
