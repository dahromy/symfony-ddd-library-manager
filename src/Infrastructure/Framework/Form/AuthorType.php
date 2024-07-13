<?php

namespace App\Infrastructure\Framework\Form;

use App\Domain\Entity\Author;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class AuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Author Name',
                'attr' => [
                    'placeholder' => 'Enter author name',
                    'class' => 'form-control',
                ],
            ]);

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $author = $event->getData();
            $form = $event->getForm();

            // Check if this is a new Author (no id set)
            if (!$author || null === $author->getId()) {
                $form->add('name', TextType::class, [
                    'label' => 'Author Name',
                    'attr' => [
                        'placeholder' => 'Enter author name',
                        'class' => 'form-control',
                    ],
                    'empty_data' => '',
                ]);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Author::class,
            'empty_data' => function ($form) {
                return new Author($form->get('name')->getData() ?: '');
            },
        ]);
    }
}
