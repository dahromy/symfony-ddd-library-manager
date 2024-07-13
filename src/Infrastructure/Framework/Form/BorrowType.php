<?php

namespace App\Infrastructure\Framework\Form;

use App\Domain\Entity\BorrowRecord;
use App\Domain\Entity\Book;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
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

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $data = $event->getData();
            $form = $event->getForm();

            if (!$form->getData() instanceof BorrowRecord) {
                $bookRepository = $form->getConfig()->getOption('book_repository');
                $book = $bookRepository->find($data['book']);

                if ($book) {
                    $borrowDate = isset($data['borrowDate']) ? new \DateTime($data['borrowDate']) : new \DateTime();
                    $borrowRecord = new BorrowRecord(
                        $book,
                        $data['borrowerName'] ?? '',
                        $borrowDate
                    );
                    $form->setData($borrowRecord);
                }
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BorrowRecord::class,
        ]);
        $resolver->setRequired('book_repository');
    }
}
