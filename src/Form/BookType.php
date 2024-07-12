<?php

namespace App\Form;

use App\Domain\Entity\Author;
use App\Domain\Repository\AuthorRepositoryInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    private $authorRepository;

    public function __construct(AuthorRepositoryInterface $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => ['class' => 'form-input mt-1 block w-full'],
                'label_attr' => ['class' => 'block text-sm font-medium text-gray-700'],
            ])
            ->add('isbn', TextType::class, [
                'attr' => ['class' => 'form-input mt-1 block w-full'],
                'label_attr' => ['class' => 'block text-sm font-medium text-gray-700'],
            ])
            ->add('author', EntityType::class, [
                'class' => Author::class,
                'choice_label' => 'name',
                'choices' => $this->authorRepository->findAll(),
                'attr' => ['class' => 'form-select mt-1 block w-full'],
                'label_attr' => ['class' => 'block text-sm font-medium text-gray-700'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
