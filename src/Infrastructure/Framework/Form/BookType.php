<?php

namespace App\Infrastructure\Framework\Form;

use App\Domain\Entity\Author;
use App\Domain\Entity\Book;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Book Title',
                'attr' => ['placeholder' => 'Enter book title'],
            ])
            ->add('isbn', TextType::class, [
                'label' => 'ISBN',
                'attr' => ['placeholder' => 'Enter ISBN'],
            ])
            ->add('author', EntityType::class, [
                'class' => Author::class,
                'choice_label' => 'name',
                'label' => 'Author',
                'placeholder' => 'Select an author',
            ]);

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $book = $event->getData();
            $form = $event->getForm();

            // Check if this is a new Book (no id set)
            if (!$book || null === $book->getId()) {
                $form->add('title', TextType::class, [
                    'label' => 'Book Title',
                    'attr' => ['placeholder' => 'Enter book title'],
                    'empty_data' => '',
                ]);
                $form->add('isbn', TextType::class, [
                    'label' => 'ISBN',
                    'attr' => ['placeholder' => 'Enter ISBN'],
                    'empty_data' => '',
                ]);
            }
        });

        $builder->addEventListener(FormEvents::PRE_SUBMIT, [$this, 'onPreSubmit']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
            'empty_data' => function ($form) {
                return new Book(
                    $form->get('title')->getData() ?: '',
                    $form->get('isbn')->getData() ?: '',
                    $form->get('author')->getData()
                );
            },
        ]);
    }

    public function onPreSubmit(FormEvent $event)
    {
        $data = $event->getData();
        
        // Ensure ISBN is not null
        if (!isset($data['isbn']) || $data['isbn'] === null) {
            $data['isbn'] = '';
        }

        // Trim whitespace from title and ISBN
        if (isset($data['title'])) {
            $data['title'] = trim($data['title']);
        }
        if (isset($data['isbn'])) {
            $data['isbn'] = trim($data['isbn']);
        }

        $event->setData($data);
    }
}
