<?php

namespace App\Infrastructure\Framework\Form;

use App\Domain\Entity\BorrowRecord;
use App\Domain\Entity\Book;
use App\Domain\Entity\Author;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class BorrowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('book', EntityType::class, [
                'class' => Book::class,
                'choice_label' => 'title',
            ])
            ->add('borrowerName', TextType::class, [
                'label' => 'Borrower Name',
            ]);

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $borrowRecord = $event->getData();
            $form = $event->getForm();

            if (!$borrowRecord || null === $borrowRecord->getId()) {
                $tempAuthor = new Author('Temporary Author');
                $borrowRecord = new BorrowRecord(
                    new Book('Temporary Title', 'Temporary ISBN', $tempAuthor), // Temporary Book instance
                    '',
                    new \DateTime()
                );
                $event->setData($borrowRecord);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BorrowRecord::class,
        ]);
    }
}
