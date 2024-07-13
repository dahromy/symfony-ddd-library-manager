<?php

namespace App\Infrastructure\Framework\Form;

use App\Domain\Entity\Author;
use App\Domain\Entity\Book;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Isbn;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Type;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => ['class' => 'appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm', 'placeholder' => 'Enter book title'],
                'label' => 'Title',
                'label_attr' => ['class' => 'sr-only'],
                'constraints' => [
                    new NotBlank(['message' => 'Please enter a title']),
                    new NotNull(['message' => 'Please enter a title']),
                    new Length(['min' => 2, 'max' => 255, 'minMessage' => 'The title must be at least {{ limit }} characters long', 'maxMessage' => 'The title cannot be longer than {{ limit }} characters']),
                ],
            ])
            ->add('isbn', TextType::class, [
                'attr' => ['class' => 'appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm', 'placeholder' => 'Enter ISBN'],
                'label' => 'ISBN',
                'label_attr' => ['class' => 'sr-only'],
                'constraints' => [
                    new NotBlank(['message' => 'Please enter an ISBN']),
                    new NotNull(['message'=> 'Please enter an ISBN']),
                    new Isbn(['message' => 'This is not a valid ISBN']),
                ],
            ])
            ->add('author', EntityType::class, [
                'class' => Author::class,
                'choice_label' => 'name',
                'attr' => ['class' => 'appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm'],
                'label' => 'Author',
                'label_attr' => ['class' => 'sr-only'],
                'placeholder' => 'Select an author',
                'constraints' => [
                    new NotBlank(['message' => 'Please select an author']),
                    new NotNull(['message' => 'Please select an author']),
                    new Type([
                        'type' => Author::class,
                        'message' => 'The selected author is invalid',
                    ])
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
            'empty_data' => function (FormInterface $form) {
                return new Book(
                    $form->get('title')->getData() ?? '',
                    $form->get('isbn')->getData() ?? '',
                    $form->get('author')->getData()
                );
            },
        ]);
    }
}
