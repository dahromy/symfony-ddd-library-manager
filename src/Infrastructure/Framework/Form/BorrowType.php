<?php

namespace App\Infrastructure\Framework\Form;

use App\Domain\Entity\Book;
use App\Domain\Entity\BorrowRecord;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class BorrowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('book', EntityType::class, [
                'class' => Book::class,
                'choice_label' => 'title',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('b')
                        ->orderBy('b.title', 'ASC');
                },
                'attr' => ['class' => 'appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm'],
                'label' => 'Book',
                'label_attr' => ['class' => 'sr-only'],
                'placeholder' => 'Select a book',
                'constraints' => [
                    new NotNull(['message' => 'Please select a book']),
                    new NotBlank(['message' => 'Please select a book']),
                ],
            ])
            ->add('borrowerName', TextType::class, [
                'attr' => ['class' => 'appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm', 'placeholder' => 'Enter borrower name'],
                'label' => 'Borrower Name',
                'label_attr' => ['class' => 'sr-only'],
                'constraints' => [
                    new NotBlank(['message' => 'Please enter a borrower name']),
                    new NotNull(['message' => 'Please enter a borrower name']),
                    new Length(['min' => 2, 'max' => 255, 'minMessage' => 'The borrower name must be at least {{ limit }} characters long', 'maxMessage' => 'The borrower name cannot be longer than {{ limit }} characters']),
                ],
            ])
            ->add('borrowDate', DateType::class, [
                'label' => 'Borrow Date',
                'label_attr' => ['class' => 'sr-only'],
                'widget' => 'single_text',
                'data' => new \DateTime(),
                'attr' => ['class' => 'appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm'],
                'constraints' => [
                    new NotNull(['message' => 'Please select a borrow date']),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BorrowRecord::class,
            'empty_data' => function ($form) {
                $book = $form->get('book')->getData();
                $borrowerName = $form->get('borrowerName')->getData();
                $borrowDate = $form->get('borrowDate')->getData();

                if ($book !== null && $borrowerName !== null && $borrowDate !== null) {
                    return new BorrowRecord($book, $borrowerName, $borrowDate);
                }

                return null;
            },
        ]);
    }
}
