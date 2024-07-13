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
                'attr' => ['class' => 'appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm', 'placeholder' => 'Enter author name'],
                'label' => 'Author Name',
                'label_attr' => ['class' => 'sr-only'],
                'empty_data' => '',
                'constraints' => [
                    new NotBlank(['message' => 'Please enter an author name']),
                    new NotNull(['message' => 'Please enter an author name']),
                    new Length(['min' => 2, 'max' => 255, 'minMessage' => 'The author name must be at least {{ limit }} characters long', 'maxMessage' => 'The author name cannot be longer than {{ limit }} characters']),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Author::class,
            'empty_data' => function ($form) {
                $name = $form->get('name')->getData();
                return $name !== null ? new Author($name) : null;
            },
        ]);
    }
}
