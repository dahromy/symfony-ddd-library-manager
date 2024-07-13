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
            ])
            ->add('borrowerName', TextType::class, [
                'label' => 'Borrower Name',
            ])
            ->add('borrowDate', DateType::class, [
                'label' => 'Borrow Date',
                'widget' => 'single_text',
                'data' => new \DateTime(),
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BorrowRecord::class,
            'empty_data' => fn ($form) => new BorrowRecord($form->get('book')->getData(), $form->get('borrowerName')->getData(), $form->get('borrowDate')->getData())
        ]);
    }
}
